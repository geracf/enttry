<template>

    <div class="cv">
        <div class="cv__image">
            <img :src="pic_url">
        </div>
        <div class="cv__title">
            <h4 v-text="name"></h4>
            <p v-text="subtitle"></p>
        </div>
        <div class="cv__section" v-for="section in sections">
            <p class="title" v-text="section.title"></p>
            <p v-text="section.body"></p>
        </div>
        <div class="cv__social">
            <h4>Socials</h4>
            <p v-for="social in socials">
                <a v-if="social.active" :href="social.address">
                    <i class="fa" :class="social.icon"></i>
                    <!-- <span v-text="social.network"></span> -->
                    <span v-text="social.network"></span>
                </a>
            </p>
        </div>
        <div class="cv__actions" style="margin-bottom: 30px;">
            <a href="/start" class="btn btn-success">Crear/Editar CV</a>
        </div>
    </div>

</template>

<script>
    export default {
        data() {

            return {
                pic_url: 'https://jobshere.s3-us-west-1.amazonaws.com/dummy/placeholder.png',
                name: 'Cargando...',
                subtitle: 'Campo de interés',
                sections: [
                    {
                        title: 'Educación',
                        body: 'Aqui va tu educación'
                    },
                    {
                        title: 'Edad',
                        body: 'Tu edad acá'
                    }
                ],
                socials: [
                    {
                        active: true,
                        icon: 'fa-at',
                        network: 'email',
                        address: 'tucorreo@ejemplo.com'
                    },
                    {
                        active: true,
                        icon: 'fa-linkedin',
                        network: 'LinkedIn',
                        address: null
                    },
                    {
                        active: true,
                        icon: 'fa-twitter',
                        network: 'Twitter',
                        address: null
                    },
                    {
                        active: true,
                        icon: 'fa-spotify',
                        network: 'Spotify',
                        address: null
                    },
                    {
                        active: true,
                        icon: 'fa-instagram',
                        network: 'Intagram',
                        address: null
                    }
                ]
            }

        },
        mounted () {
            axios.get('api/user')
                .then(res => {
                    console.log(res)
                    this.pic_url = res.data.pic_url
                    this.name = res.data.name
                    this.socials = res.data.socials
                    this.sections[0] = res.data.education
                    this.sections[1] = res.data.age
                    this.subtitle = res.data.subtitle
                })
                .catch(err => {
                    console.log(err)
                })
        }
    }
</script>
