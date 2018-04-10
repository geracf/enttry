<template>

    <div class="row company-dashboard">
        <div class="title">
            <h1 v-text="title"></h1>
            <a href="#" @click="openModal">
                <i class="fa fa-pencil"></i>
            </a>
        </div>
        <div class="row margin-bottom">
            <div class="col-md-12 no-padding margin-bottom card-responsive">
                <company-bio
                    :bio="bio"
                    :url="url"
                    :token="token"></company-bio>
            </div>
            <div class="col-md-12 card-responsive">
                <company-striped
                    title="Notificaciones"
                    :list="notifications"
                    empty_text="No hay notificaciones..."></company-striped>
            </div>
        </div>
        <div class="row margin-bottom">
            <div class="col-md-6 no-padding card-responsive">
                <company-striped
                title="Redes sociales"
                :list="social"></company-striped>
            </div>
            <div class="col-md-6 no-padding card-responsive">
                <company-striped
                title="Plan actual"
                :list="plan"
                :hasButton="true"
                :action="plan_action"></company-striped>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['title', 'base_url', 'url', 'token', 'plan_action'],
        data() {

            return {
                bio: { img: '/img/student-background.png', name: '', body: '' },
                notifications: {
                    headers: [
                        { title: 'Notificación', right: false },
                        { title: 'Date', right: true },
                    ],
                    data: [
                        { tag: 'Loading…', body: '' },
                    ],
                },
                social: {
                    data: [
                        { tag: 'Twitter', body: '' },
                        { tag: 'Facebook', body: '' },
                        { tag: 'Linkedin', body: '' },
                    ],
                },
                plan: {
                    data: [
                        { tag: 'Ofertas restantes', body: 'Loading…' },
                        { tag: 'Discoveries restantes', body: 'Loading…' },
                        { tag: 'AI assistant', body: 'Loading…' },
                    ]
                }
            }
        },
        methods: {
            getOrganization() {
                axios.get('api/organization/self')
                    .then(res => {
                        this.setBio(res.data)
                        this.setPlan(res.data)
                        this.setSocials(res.data)
                        this.setNotifications(res.data)
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            setBio(res) {
                this.bio.img = res.thumbnail
                this.bio.name = res.name
                this.bio.body = res.desc
            },
            setPlan(res) {
                this.plan.data[0].body = res.remaining_offers
                this.plan.data[1].body = res.remaining_discover
                this.plan.data[2].body = res.ai_assistant_enabled
                console.log(res)
            },
            setSocials(res) {
                if (res.twitter) this.social.data[0].body = res.twitter
                if (res.facebook) this.social.data[1].body = res.facebook
                if (res.linkedin) this.social.data[2].body = res.linkedin
                // console.log(this.social.data)
            },
            setNotifications(res) {
                this.notifications.data = []
                console.log(res)
                var arr = Object.keys(res.unread_notifications).map(function (key) { return res.unread_notifications[key]; });
                for (var i = 0; i <= arr.length; i++) {
                    if (i === 5) { break }
                    let notification = {
                        tag: '<a href="' + this.base_url + '/chats">'+ res.unread_notifications[i].data.message +'</a>',
                        body: res.unread_notifications[i].created_at,
                    }
                    this.notifications.data.push(notification)
                }
            },
            openModal() {
                $('#modifyOrganization').modal('show')
            }
        },
        mounted() {
            this.getOrganization()
            Event.$on('organization:changed', () => {
                this.getOrganization()
            })
        }
    }
</script>
