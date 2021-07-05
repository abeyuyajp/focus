<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="800px">

      <v-card>
        <v-card-title>
          <span class="headline">新規登録</span>
        </v-card-title>
        <v-card-text>
          <v-form ref="test_form">
          <v-container>
            <v-row>

              <v-col cols="12" sm="12" md="12">
                <v-text-field label="どんな作業をする予定ですか？" required v-model="work_type" :rules="[required]"></v-text-field>
              </v-col>

              <v-col cols="12" sm="12" md="12">
                <v-text-field label="ルーム名  ※ビデオチャット入室時に入力していただきます。" required v-model="room_name" :rules="[required]"></v-text-field>
              </v-col>


                <v-chip
                    class="ma-2"
                    label
                >
                    Start
                </v-chip>
                <v-time-picker v-model="start" ></v-time-picker>
              

                <v-chip
                    class="ma-2"
                    label
                >
                    End
                </v-chip>
                <v-time-picker v-model="end" ></v-time-picker>
              


            </v-row>
          </v-container>
        </v-form>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">閉じる</v-btn>
          <v-btn color="blue darken-1" text @click="save">保存</v-btn>
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
        required: value => !!value || "必ず入力してください"
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
            if (this.$refs.test_form.validate()) {
              this.success = true;
              this.dialog = false;
            }else {
              this.success = false;
            }
            
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
            //保存ができたら投稿フォームを閉じる。
            this.dialog = false;

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
  