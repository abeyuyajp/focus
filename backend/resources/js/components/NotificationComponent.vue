<template>
    <div class="btn-group">
        <span v-if="not_checked_list.length != 0"><i class="fas fa-circle not-check-icon"></i></span>

        <a id="navbarDropdownSearch" class="pl-1 nav-link" href="#"
            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="far fa-bell size"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownSearch">
            <div class="title">
                <p class="text-center"><strong>通知</strong></p>
            </div>

            <div v-if="notice == 0" class="px-2">
                <p>通知はありません</p>
            </div>

            <ul v-for="val in notice" :key="val.id" style="list-style: none;" class="mb-1 px-3">
                <li v-if="val.data.from_user_name">
                    <a v-if="val.data.status" class="dropdown-item already-check-color" href="#" @click="post_url(val, val.data.post_id)">
                        <div class="row">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x"  style="color: #28a745;"></i>
                            </div>
                            <div class="ml-5">
                                <p>
                                    {{ val.data.from_user_name }}さんがあなたのセッションにジョインしました。
                                </p>
                                <p class="text-primary">
                                    <i class="far fa-clock"></i>
                                    {{ val.data.joined_post_start | moment2 }}~{{ val.data.joined_post_end | moment3 }}
                                </p>
                                <p class="text-muted mt-2">
                                    {{ val.data.joined_created_at | moment }}
                                </p>
                            </div>
                        </div>
                    </a>
                    <a v-else class="dropdown-item not-check-color" href="#" @click="post_url(val, val.data.post_id)">
                        <div class="row">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x"  style="color: #28a745;"></i>
                            </div>
                            <div class="ml-5">
                                <p>
                                    {{ val.data.from_user_name }}さんがあなたのセッションにジョインしました。
                                </p>
                                <p class="text-primary">
                                    <i class="far fa-clock"></i>
                                    {{ val.data.joined_post_start | moment2 }}~{{ val.data.joined_post_end | moment3 }}
                                </p>
                                <p class="text-muted mt-2">
                                    {{ val.data.joined_created_at | moment }}
                                </p>
                            </div>
                        </div>
                    </a>
                </li>


                <li v-if="val.data.from_user_deleted_name">
                    <a v-if="val.data.status" class="dropdown-item already-check-color" href="#" @click="post_url(val, val.data.post_id)">
                        <div class="row">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-minus-circle fa-2x" style="color: #c0c0c0;"></i>
                            </div>
                            <div class="ml-5">
                                <p>
                                    {{ val.data.from_user_deleted_name }}さんがあなたとのセッションをキャンセルしました。
                                </p>
                                <p class="text-primary">
                                    <i class="far fa-clock"></i>
                                    {{ val.data.deleted_post_start | moment2 }}~{{ val.data.deleted_post_end | moment3 }}
                                </p>
                                <p class="text-muted mt-2">
                                    {{ val.data.created_at | moment }}
                                </p>
                            </div>
                        </div>
                    </a>
                    <a v-else class="dropdown-item not-check-color" href="#" @click="post_url(val, val.data.post_id)">
                        <div class="row">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-minus-circle fa-2x" style="color: #c0c0c0;"></i>
                            </div>
                            <div class="ml-5">
                                <p>
                                    {{ val.data.from_user_deleted_name }}さんがあなたとのセッションをキャンセルしました。
                                </p>
                                <p class="text-primary">
                                    <i class="far fa-clock"></i>
                                    {{ val.data.deleted_post_start | moment2 }}~{{ val.data.deleted_post_end | moment3 }}
                                </p>
                                <p class="text-muted mt-2">
                                    {{ val.data.created_at | moment }}
                                </p>
                            </div>
                        </div>
                    </a>
                </li>

                <hr>

            </ul>

            <div>
                <a class="dropdown-item text-center text-secondary" href="#" @click="index_url()">
                    <small>全てのお知らせを見る</small>
                </a>
            </div>
        </div>
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
            return moment(date).format("MM/DD HH:mm")
        },
        moment3: function (date) {
            return moment(date).format("HH:mm")
        }
  },
  props: ['current_user'],
  data() {
    return{
      notice: [],
      not_checked_list: []
    }
  },
  created() {
    Echo.channel('notice').listen('Notice', (e) => {
      this.get_notice()
    })
    this.get_notice()
  },
  methods: {
    index_url() {
      const id = this.current_user.id
      const array = ["/user/", id, "/notice_index"];
      const link = array.join('')
      window.location.href = link
    },
    post_url(val, post_id) {
      this.status_checked(val)
      const array = ["/posts/", post_id];
      const link = array.join('')
      window.location.href = link
    },
    get_notice() {
      const id = this.current_user.id
      const array = ["/user/", id, "/notice_get"];
      const path = array.join('')
      axios.get(path).then(res => {
        this.notice = res.data
        this.not_checked_list = this.notice.filter(val => val.data.status == false)
      }).catch(function(err) {
        console.log(err)
      })
    },
    status_checked(val) {
      if(val.data.status == false) {
        const id = this.current_user.id
        const array = ["/user/",id,"/notice_checked"];
        const path = array.join('')
        axios.put(path, val).then(res => {
          this.get_notice()
        }).catch(function(err) {
          console.log(err)
        })
      }
    }
  }
}
</script>

<style scoped>
.not-check-color {
  background-color: white;
}

.already-check-color {
  background-color: white;
}

.not-check-icon {
  font-size: 0.5em;
  color: #528fff;
}

p {
  margin-bottom: 0;
  font-size: 13px;
}

.size {
  font-size:1.5em;
  color: white;
}
</style>