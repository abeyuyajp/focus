<template>
  <div>

    <div id="form-modal">
      <create-component ref="form" @save="saveEvent"></create-component>
    </div>

    <v-menu bottom right>
      <template v-slot:activator="{ on }">
        <v-btn
          outlined
          color="grey darken-2"
          v-on="on"
        >
          <span>{{type}}</span>
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

    <v-sheet height="500">
      <v-calendar
          ref="calendar"
          locale="ja-jp"
          :type="type"
          :now="today"
          :value="today"
          :events="events"
          color="primary"
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
                <span v-html="selectedEvent.id"></span>
                <span v-html="selectedEvent.name"></span>
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
  export default {
    data: () => ({
    today: `2021-05-01`,
    type:'month',
    datas:[],
    events: [
        {
          name: 'あたりまえ体操をする',
          start: '2021-05-18',
          end: '2021-05-1',
          id : 1,
        },
        {
          name: 'ミーティング',
          start: '2021-05-1 09:00',
          end: '2021-05-1 10:00',
          id : 2,
        },
      ],
      eventAlert : false,
      selectedItem : null,
      selectedEvent : {},

    }),
    computed:{
   
    },
    mounted () {

    },
    methods:{
        showDay( { date } ){
          this.today = date
          this.type = 'day'
        },
        createEvent( { date } ){
          this.$refs.form.open(date);
        },
        saveEvent(params){
          this.events.push(params);
          console.log(`保存しました。${params}`)
        },
        clickEvent( {nativeEvent, event} ){
          this.selectedEvent = event;
          this.selectedItem = nativeEvent.target;
          setTimeout( () => this.eventAlert = true, 10 );

          nativeEvent.stopPropagation();
        },
        deleteEvent(){
          let newArray = this.events.filter( item => {
              return item.id != this.selectedEvent.id
          });

          this.events = newArray;
          this.eventAlert = false;
        }
    }
  }
</script>