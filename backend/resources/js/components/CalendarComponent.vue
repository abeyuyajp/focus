<template>
  <div>

    <div id="form-modal">
      <create-component ref="form" @save="saveEvent"></create-component>
    </div>

<v-sheet height="64">
  <v-toolbar flat>
    <v-btn
      outlined
      class="mr-4"
      color="grey darken-2"
      @click="setToday"
    >
      Today
    </v-btn>
    <v-btn
      icon
      class="ma-2"
      color="blue"
      @click="prev"
    >
      <v-icon>mdi-chevron-left</v-icon>
    </v-btn>
    <v-btn
      icon
      class="ma-2"
      color="blue"
      @click="next"
    >
      <v-icon>mdi-chevron-right</v-icon>
    </v-btn>
    <v-toolbar-title v-if="$refs.calendar">
      {{ $refs.calendar.title }}
    </v-toolbar-title>
    <v-spacer></v-spacer>
    <v-menu bottom right>
      <template v-slot:activator="{ on }">
        <v-btn
          outlined
          color="grey darken-2"
          v-on="on"
        >
          <span>{{ typeToLabel[type] }}</span>
          <v-icon right>
            mdi-menu-down
          </v-icon>
        </v-btn>
      </template>
      <v-list>
        <v-list-item @click="type = 'day'">
          <v-list-item-title>Day</v-list-item-title>
        </v-list-item>
        <v-list-item @click="type = 'week'">
          <v-list-item-title>Week</v-list-item-title>
        </v-list-item>
        <v-list-item @click="type = 'month'">
          <v-list-item-title>Month</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-toolbar>
</v-sheet>
<v-sheet height="80vh">
  <v-calendar
      ref="calendar"
      locale="ja-jp"
      :type="type"
      :now="today"
      :value="today"
      v-model="focus"
      color="primary"
      :events="events"
      @click:event="clickEvent"
      @click:date="showDay"
      @click:day="createEvent"
  ></v-calendar>
</v-sheet>
<v-menu
        v-model="eventAlert"
        :close-on-content-click="false"
        :activator="selectedItem"
      >
        <v-card
          color="grey lighten-4"
          min-width="350px"
          flat
        >
              <v-card-text>
                <span v-html="selectedEvent.work_type"></span>
              </v-card-text>

              <v-btn
                text
                color="primary"
                @click="eventAlert = false"
              >
                閉じる
              </v-btn>

              <v-btn
                text
                color="error"
                @click="deleteEvent"
              >
                削除
              </v-btn>
        </v-card>
    </v-menu>

  </div>
</template>

<script>
import moment from 'moment';

  export default {
    data: () => ({
      focus: '',
      type:'month',
      typeToLabel: {
        month: 'Month',
        week: 'Week',
        day: 'Day',
      },
      datas:[],
      events: [],
      eventAlert : false,
      selectedItem : null,
      selectedEvent : {},
      value: moment().format('yyyy-MM-DD'), 
    }),
    computed:{
      
    },
    mounted () {
        this.getAllEvent();
        axios.get('/get/calendar')
          .then( res => {
              this.events = res.data;
          })
          .catch( e => {
              console.log(e);
          })
    },
    methods:{
        showDay( { date } ){
          this.today = date
          this.type = 'day'
        },

        //フォームを表示するメソッド
        createEvent( { date } ){
          this.$refs.form.open(date);
        },

        setToday () {
          this.focus = this.today
        },

        //前の月
        prev(){
          this.$refs.calendar.prev()
        },

        //次の月
        next(){
          this.$refs.calendar.next()
        },

        //投稿を保存するメソッド
        async saveEvent(params){
          await axios.post('/posts', params)
            .then( res => {
              console.log(res);
            })
            .catch( e => {
              console.log(e);
            })
            .finally( () => {
               this.getAllEvent();
            })
          console.log("保存しました。");
        },

        clickEvent( {nativeEvent, event} ){
          this.selectedEvent = event;
          this.selectedItem = nativeEvent.target;
          setTimeout( () => this.eventAlert = true, 10 );

          nativeEvent.stopPropagation();
        },

        //削除メソッド
        async deleteEvent(){
          const params = {
            id : this.selectedEvent.id
          }

          await axios.post('/delete',params)
            .then( res => {
              alert("削除しました。");
            })
            .catch( e => {
              console.log(e);
            })
            .finally( () => {
              this.getAllEvent();
            })

          //閉じる
          this.eventAlert = false;
        },

        //更新後の一覧を取得するメソッド
        async getAllEvent(){
          axios.get('/get/calendar')
          .then( res => {
              this.events = res.data;
          })
          .catch( e => {
              console.log(e);
          })
        },
    }
  }
</script>