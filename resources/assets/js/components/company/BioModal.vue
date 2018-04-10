<template>

    <div class="modal fade" tabindex="-1" role="dialog" id="modifyOrganization">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar {{ organization.name }}</h4>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <p>Imágen de perfil de la organización</p>
                            <div class="cv__image">
                                <img :src="organization.img">
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <dropzone id="myVueDropzone"
                                :url="url"
                                v-on:vdropzone-success="showSuccess"
                                :useFontAwesome="true"
                                dictDefaultMessage="Upload your avatar"
                                maxFiles="1">
                                <input type="hidden" name="_token" :value="token">
                                </dropzone>
                        </div>
                    </div>

                    <form>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Nombre de la organización</label>
                                    <input class="form-control" type="text" v-model="organization.name" placeholder="The name of your organization">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <input class="form-control" type="text" v-model="organization.address" placeholder="Your address">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Cuéntales un poco de tí a los estudiantes</label>
                                    <textarea class="form-control" v-model="organization.bio" placeholder="Describe your organization"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Facebook</label>
                                    <input class="form-control" type="text" v-model="organization.facebook" placeholder="Facebook profile">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>LinkedIn</label>
                                    <input class="form-control" type="text" v-model="organization.linkedin" placeholder="Linkedin profile">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Twitter</label>
                                    <input class="form-control" type="text" v-model="organization.twitter" placeholder="Twitter profile">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Página web</label>
                                    <input class="form-control" type="text" v-model="organization.website" placeholder="Official website">
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Correo de contacto</label>
                                    <input class="form-control" type="text" v-model="organization.email" placeholder="Contact email">
                                </div>
                            </div>
                        </div>


                    </form>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" @click="postOrganization">Editar</button>
                </div>

            </div>
        </div>
    </div>

</template>

<script>
    import Dropzone from 'vue2-dropzone'

    export default {
        props: {
            token: String,
            url: {
                type: String,
                default: '',
            }
        },
        data () {
            return {
                organization: {
                    name: null,
                    bio: null,
                    img: null
                }
            }
        },
        methods: {
            getOrganization() {
                // alert('getOrganization')
                axios.get('api/organization/self')
                    .then(res => {
                        this.organization.id = res.data.id
                        this.organization.address = res.data.address
                        this.organization.name = res.data.name
                        this.organization.bio = res.data.desc
                        this.organization.img = res.data.thumbnail
                        this.organization.facebook = res.data.facebook
                        this.organization.linkedin = res.data.linkedin
                        this.organization.twitter = res.data.twitter
                        this.organization.website = res.data.website
                        this.organization.email = res.data.email
                        console.log(this.organization)
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            postOrganization() {
                let data = {
                    _method: 'put',
                    address: this.organization.address,
                    name: this.organization.name,
                    desc: this.organization.bio,
                    facebook: this.organization.facebook,
                    twitter: this.organization.twitter,
                    linkedin: this.organization.linkedin,
                    email: this.organization.email,
                    website: this.organization.website,
                }

                axios.post('api/organization/' + this.organization.id, data)
                    .then(res => {
                        Event.$emit('organization:changed');
                        $('#modifyOrganization').modal('hide');
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            showSuccess() {
                console.log('A file was successfully uploaded')
                this.getOrganization()
            }
        },
        mounted() {
            this.getOrganization()
        },
        components: {
            Dropzone
        }
    }
</script>