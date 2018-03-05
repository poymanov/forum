<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Notifications</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a :href="notification.data.link"
               class="dropdown-item"
               v-for="notification in notifications"
               v-text="notification.data.message"
                @click="markAsRead(notification.id)"></a>
        </div>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                notifications: []
            }
        },
        created() {
            this.getNotifications();
        },
        methods: {
            getNotifications() {
                axios.get("/profile/" + window.App.user.name + "/notifications").then(({data}) => {this.notifications = data});
            },
            markAsRead(id) {
                axios.delete("/profile/" + window.App.user.name + "/notifications/" + id)
            }
        }
    }
</script>