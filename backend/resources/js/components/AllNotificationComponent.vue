<template>

<div>
    <div v-if="notice == 0" class="px-2">
        <p>通知はありません</p>
    </div>
    <ul v-for="val in notice" :key="val.id" style="list-style: none; background-color: white; "class="p-4">
        <li v-if="val.data.from_user_name">
            <a href="#" @click="post_url(val, val.data.post_id)" style="text-decoration: none; color: black;">
                <div class="row">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle fa-3x"  style="color: #28a745;"></i>
                    </div>
                    <div class="ml-5">
                        <p style="margin-bottom: 5px;">
                            {{ val.data.from_user_name }}さんがあなたのセッションにジョインしました。
                        </p>
                        <p class="text-primary" style="margin-bottom: 5px;">
                            <i class="far fa-clock"></i>
                            {{ val.data.joined_post_start | moment2 }}~{{ val.data.joined_post_end | moment3 }}
                        </p>
                        <p>
                            {{ val.data.joined_created_at | moment }}
                        </p>
                    </div>
                </div>
            </a>
        </li>
        <li v-if="val.data.from_user_deleted_name">
            <a href="#" @click="post_url(val, val.data.post_id)"style="text-decoration: none; color: black;">
                <div class="row">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-minus-circle fa-3x" style="color: #c0c0c0;"></i>
                    </div>
                    <div class="ml-5">
                        <p style="margin-bottom: 5px;">
                            {{ val.data.from_user_deleted_name }}さんがあなたとのセッションをキャンセルしました。
                        </p>
                        <p class="text-primary" style="margin-bottom: 5px;">
                            <i class="far fa-clock"></i>
                            {{ val.data.deleted_post_start | moment2 }}~{{ val.data.deleted_post_end | moment3 }}
                        </p>
                        <p>
                            {{ val.data.created_at | moment }}
                        </p>
                    </div>
                </div>
            </a>
        </li>
    </ul>
</div>

</template>


<script>
    import moment from 'moment';
    import 'moment/locale/ja' ;
    export default {
        filters: {
            moment: function (date) {
                return moment(date).format("MM/DD");
            },
            moment2: function (date) {
                return moment(date).format("MM/DD HH:mm");
            },
            moment3: function (date) {
                return moment(date).format("HH:mm");
            }
        },
        props: ['current_user'],
        data() {
            return {
                notice: []
            }
        },
        created() {
            Echo.channel('notice').listen('Notice', (e) => {
                this.get_all_notice()
            })
            this.get_all_notice()
        },
        methods: {
            post_url(val, post_id) {
                const array = ["/posts/", post_id];
                const link = array.join('')
                window.location.href = link
            },
            get_all_notice() {
                const id = this.current_user.id
                const array = ["/user/", id, "/notice_all_get"];
                const path = array.join('')
                axios.get(path).then(res => {
                    this.notice = res.data
                }).catch(function(err){
                    console.log(err)
                })
            }
        }
    }

</script>