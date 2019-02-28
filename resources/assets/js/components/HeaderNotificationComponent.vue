<template>
    <ul class="nav navbar-nav noticebar navbar-right  " style=" padding-right:50px;">
        <li class="dropdown">
            <a href="page-notifications.html" class="dropdown-toggle" data-toggle="dropdown" v-on:click="markAsunread()">
                <i class="fa fa-bell"></i>
                <span class="navbar-visible-collapsed">&nbsp;Notifications&nbsp;</span>
                <span class="badge" v-if="unread_notification_length!=0">{{unread_notification_length}}</span>
            </a>

            <ul class="dropdown-menu noticebar-menu" style="max-height: 300px; overflow-y: scroll;" role="menu">
                <li class="nav-header">
                    <div class="pull-left">
                        Notifications
                    </div>

                    <div class="pull-right">
                        <a href="javascript:;" v-on:click="markAsunread()">Mark as Read</a>
                    </div>
                </li>

                <li v-if="unreadNotifications.length==0">
                    <a href="#">No unread Notifications</a>
                </li>
                <li v-for="(unread, index) in unreadNotifications" v-else>
                    <a href="page-notifications.html" class="noticebar-item">
                        <span class="noticebar-item-image">
                          <i class="fa fa-cloud-upload text-success"></i>
                        </span>
                        <span class="noticebar-item-body">
                          <strong class="noticebar-item-title">{{unread.data.thread.title}}</strong>
                          <span class="noticebar-item-text">{{unread.data.thread.description}}</span>
                          <span class="noticebar-item-time"><i class="fa fa-clock-o"></i> {{unread.created_at | moment}}</span>
                        </span>
                    </a>
                </li>


                <li class="noticebar-menu-view-all">
                    <a href="page-notifications.html">View All Notifications</a>
                </li>

            </ul>
        </li>
        <li class="dropdown">
            <a href="page-notifications.html" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope"></i>
                <span class="navbar-visible-collapsed">&nbsp;Messages&nbsp;</span>
            </a>

            <ul class="dropdown-menu noticebar-menu" role="menu">
                <li class="nav-header">
                    <div class="pull-left">
                        Messages
                    </div>

                    <div class="pull-right">
                        <a href="javascript:;">New Message</a>
                    </div>
                </li>

                <li>
                    <a href="page-notifications.html" class="noticebar-item">
                <span class="noticebar-item-image">
                  <!--<img src="img/avatars/avatar-1-md.jpg" style="width: 50px" alt="">-->
                </span>

                        <span class="noticebar-item-body">
                  <strong class="noticebar-item-title">New Message</strong>
                  <span class="noticebar-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</span>
                  <span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 20 minutes ago</span>
                </span>
                    </a>
                </li>

                <li>
                    <a href="page-notifications.html" class="noticebar-item">
                <span class="noticebar-item-image">
                 <!-- <img src="img/avatars/avatar-2-md.jpg" style="width: 50px" alt="">-->
                </span>

                        <span class="noticebar-item-body">
                  <strong class="noticebar-item-title">New Message</strong>
                  <span class="noticebar-item-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit...</span>
                  <span class="noticebar-item-time"><i class="fa fa-clock-o"></i> 5 hours ago</span>
                </span>
                    </a>
                </li>

                <li class="noticebar-menu-view-all">
                    <a href="page-notifications.html">View All Messages</a>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-exclamation-triangle"></i>
                <span class="navbar-visible-collapsed">&nbsp;Alerts&nbsp;</span>
            </a>

            <ul class="dropdown-menu noticebar-menu noticebar-hoverable" role="menu">
                <li class="nav-header">
                    <div class="pull-left">
                        Alerts
                    </div>
                </li>

                <li class="noticebar-empty">
                    <h4 class="noticebar-empty-title">No alerts here.</h4>
                    <p class="noticebar-empty-text">Check out what other makers are doing on Explore!</p>
                </li>
            </ul>
        </li>
    </ul>

</template>
<script>
    import {constant} from '../constant.js';

    export default {

        props:["unreads","userid", "allnotifications", "unread_notification_count"],
        data(){
          return{
              unreadNotifications:this.unreads,
              unread_notification_length:this.unread_notification_count,

              new_unread_notifications:[],
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
                    this.unreadNotifications.unshift(new_unread_notifications);
                    axios.get(constant.base_url+'get_all_unread_notification').then((response)=>{
                        this.unread_notification_length=response.data.length;

                    });
            });

        },
        methods:{
            markAsunread:function(){
                axios.get(constant.base_url+'markAsRead').then((response)=>{
                    this.unread_notification_length=0;
                });
            }
        }
    }
</script>