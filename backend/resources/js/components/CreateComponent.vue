<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="800px">

      <v-card>
        <v-card-title>
          <span class="headline">新規登録</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>

              <v-col cols="12" sm="12" md="12">
                <v-text-field label="作業" required v-model="work_type"></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="12">
                <v-text-field label="ルーム名" required v-model="room_name"></v-text-field>
              </v-col>


              <v-col cols="6" sm="6" md="6">
                <v-chip
                    class="ma-2"
                    label
                >
                    Start
                </v-chip>
                <v-time-picker v-model="start" width="252"></v-time-picker>
              </v-col>


              <v-col cols="6" sm="6" md="6">
                <v-chip
                    class="ma-2"
                    label
                >
                    End
                </v-chip>
                <v-time-picker v-model="end" width="252"></v-time-picker>
              </v-col>


            </v-row>
          </v-container>
        
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
          <v-btn color="blue darken-1" text @click="save">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
 

<script>
  export default {
    data: () => ({
        dialog : false,
        start : null,
        end : null,
        day : "",
        work_type : "",
        room_name : "",
    }),
    methods:{
        open(date){
            this.dialog = true;
            this.day = date;
            this.start = null;
            this.end = null;
            this.work_type = "";
            this.room_name = "";
        },
        save(){
            if( !this.isNotNull(this.start, this.end) ){
              console.log("nullです");
              return ;
            }
            if( !this.compareDate(this.start,this.end) ){
              console.log("dame");
              return;
            }
            const params = {
              work_type : this.work_type,
              room_name : this.room_name,
              start : this.day + ' ' + this.start,
              end : this.day + ' ' + this.end
            }

            console.log(params);

            this.$emit('save',params);
        },

        isNotNull(start,end){
            return start && end;
        },
        compareDate(start,end){
            return start < end;
        },

    },
  }
</script>
  