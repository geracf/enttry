<template>

    <div class="col-xs-12 col-sm-3 start__card">
        <h3>Redes sociales</h3>
        <div class="start__form socials">

            <div class="row" v-for="social of socials" v-if="social.address">
                <div class="col-xs-1 col-xs-offset-1">
                    <i class="fa" :class="social.icon"></i>
                </div>
                <div class="col-xs-8">
                    <a :href="social.address" v-text="social.network"></a>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-3">
                    <i class="fa fa-plus-square-o"></i>
                </div>
                <div class="col-xs-9 info">
                    <a data-toggle="modal" data-target="#addSocialMedia" href="#">Agregar</a>
                </div>
            </div>

        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="addSocialMedia">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Agregar una red social</h4>
                    </div>
                    <div class="modal-body">

                        <form>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="sr-only">LinkedIn</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-linkedin"></i>
                                            </div>
                                            <input v-model="socials.linkedin.address" type="url" class="form-control" placeholder="LinkedIn url">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="sr-only">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-at"></i>
                                            </div>
                                            <input v-model="socials.email.address" type="email" class="form-control" placeholder="Your email address?" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="sr-only">Facebook</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-facebook"></i>
                                            </div>
                                            <input v-model="socials.facebook.address" type="url" class="form-control" placeholder="Facebook url">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="sr-only">Twitter</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-twitter"></i>
                                            </div>
                                            <input v-model="socials.twitter.address" type="url" class="form-control" placeholder="Twitter url">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="sr-only">Spotify</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-spotify"></i>
                                            </div>
                                            <input v-model="socials.spotify.address" type="url" class="form-control" placeholder="Spotify url">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="sr-only">Instagram</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-instagram"></i>
                                            </div>
                                            <input v-model="socials.instagram.address" type="url" class="form-control" placeholder="Instagram url">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="postSocials">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    export default {
        data() {
            return {
                socials: {
                    email: {},
                    linkedin: {},
                    facebook: {},
                    twitter: {},
                    spotify: {},
                    instagram: {},
                }
            }
        },
        methods: {
            getSocials() {
                axios.get('api/socials')
                    .then(res => {
                        this.socials = res.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            postSocials() {
                let data = {
                    email: this.socials.email.address,
                    linkedin: this.socials.linkedin.address,
                    facebook: this.socials.facebook.address,
                    twitter: this.socials.twitter.address,
                    spotify: this.socials.spotify.address,
                    instagram: this.socials.instagram.address,
                }
                axios.post('api/socials', data)
                    .then(res => {
                        this.callback()
                        $('#addSocialMedia').modal('hide')
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        },
        mounted() {
            this.getSocials()
        }
    }
</script>

<style>
    .socials {
        padding: 10px 0;
    }
</style>
