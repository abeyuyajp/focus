<template>
    <div class="btn-group">
        <span v-if="not_checked_list.length != 0">{{ not_checked_list.length }}</span>
        <a id="navbarDropdownSearch" class="pl-1 nav-link dropdown-toggle" href="#"
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
                    <a v-if="val.data.status" class="dropdown-item" href="#">
                        <p>
                            <i class="fas fa-user-alt" style="color: #c0c0c0;"></i>
                            {{ val.data.from_user_name }}さんがあなたのセッションにジョインしました。
                        </p>
                        <p>
                            {{ val.data.joined_created_at | moment }}
                        </p>
                    </a>
                    <a v-else class="dropdown-item not-check" href="#">
                        <p>
                            <i class="fas fa-user-alt" style="color: #c0c0c0;"></i>
                            {{ val.data.from_user_name }}さんがあなたのセッションにジョインしました。
                        </p>
                        <p>
                            {{ val.data.joined_created_at | moment }}
                        </p>
                    </a>
                </li>
                
            </ul>
        </div>
    </div>
</template>



<script>
import moment from 'moment';
import 'moment/locale/ja' ;
export default {
  filters: {
        moment: function (date) {
            return moment(date).fromNow();
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
.not-check {
  background-color: #f7f7f7;
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