<template>
    <div id="notification-popup" v-show="showPopup" class="v-fade">
        <i class="fa fa-times" style="position:absolute; right:10px; top:10px;" v-on:click="hide_popup()"></i>
        <h4>{{newTitle}}</h4>
        <p>{{newDescription}}</p>
    </div>
</template>
<script>
    export default {
        props:["userid"],
        data(){
            return{
                newTitle:'',
                newDescription:'',

                showPopup:false
            }
        },
        filters: {
            moment: function (date) {
                return moment(date).fromNow();
            },
            date_time: function (date) {
                return moment(date).format('DD-MM-YYYY h:m a');
            }
        },
        mounted(){

            Echo.private('App.User.' + this.userid)
                .notification((notification) => {
                    console.log(notification);
                    var new_unread_notifications={data:{thread:notification.thread, user:notification.user}};

                    this.newTitle=new_unread_notifications.data.thread.title;
                    this.newDescription=new_unread_notifications.data.thread.description;
                    this.showPopup=true;
                    setTimeout(function(){
                        this.showPopup=false;
                    }.bind(this), 5000);
                });

        },
        methods:{
            hide_popup(){
                this.showPopup=false;
            }
        }
    }
</script>
<style>
    #notification-popup{
        background: white;
        height:100px;
        box-shadow:0px 1px 20px -3px gray;
        padding-top:15px;
        padding-bottom:15px;
        padding-left:15px;
        padding-right:15px;
        width:500px;
        position:fixed; left:40px;
        bottom:40px;
        z-index:999;
    }
    .v-fade {
        display: inherit !important; /* override v-show display: none */
        transition: opacity 0.5s;
    }

    .v-fade[style*="display: none;"] {
        opacity: 0;
        pointer-events: none; /* disable user interaction */
        user-select: none; /* disable user selection */
    }
</style>