<template>

    <div class="col-sm-12">
        <div class="">
            <form class="form">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="cv__image--start">
                            <img :src="pic_url">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <dropzone id="myVueDropzone"
                            :url="url"
                            :useFontAwesome="true"
                            v-on:vdropzone-success="showSuccess()"
                            :options="dropzoneOptions"
                            dictDefaultMessage="Arrastra aquí tu foto"
                            maxFiles="1">
                                <input type="hidden" name="_token" :value="token">
                            </dropzone>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label>Tu nombre</label>
                            <input v-model="name" class="form-control" type="text" placeholder="Tu nombre" @blur="sendForm">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Teléfono Celular</label>
                            <input v-model="cellphone" type="text" class="form-control" placeholder="Teléfono celular" @blur="sendForm">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Platícanos de ti</label>
                    <input v-model="desc" class="form-control" type="text" placeholder="Descríbete brevemente" @blur="sendForm">
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Fecha de nacimiento</label>
                            <input v-model="dob" class="form-control" type="date" placeholder="Fecha de nacimiento" @blur="sendForm">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Tu Universidad</label>
                            <input v-model="university" type="text" class="form-control" placeholder="Universidad" @blur="sendForm">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Sexo</label>
                            <basic-select :options="sexes"
                                :selected-option="sex"
                                placeholder="Sexo"
                                @select="selectSex"></basic-select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Carrera</label>
                            <input v-model="major" type="text" class="form-control" placeholder="Carrera" @blur="sendForm">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Área de interés</label>
                            <input v-model="foi" class="form-control" type="text" placeholder="Área de interés" @blur="sendForm">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Disponibilidad de horario</label>
                            <input v-model="availability" type="text" class="form-control" placeholder="Disponibilidad" @blur="sendForm">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Fecha de graduación</label>
                            <input v-model="graduated_at" type="date" class="form-control" placeholder="Dejar vacío si no aplica" @blur="sendForm">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Estado</label>
                            <input v-model="state" type="text" class="form-control" placeholder="Estado" @blur="sendForm">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Municipio o Ciudad</label>
                            <input v-model="city" type="text" class="form-control" placeholder="Municipio o ciudad" @blur="sendForm">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

</template>

<script>
    import { BasicSelect } from 'vue-search-select'
    import Dropzone from 'vue2-dropzone'

    export default {
        props: {
            url: {
                type: String,
                default: '',
            },
            token: {
                type: String,
                default: ''
            }
        },
        data() {
            return {
                desc: null,
                name: null,
                age: { body: null },
                university: { value: null, name: null },
                major: { value: null, name: null },
                sex: { value: null, name: null },
                student_type: { value: null, name: null },
                foi: null,
                pic_url: null,
                dob: null,
                cellphone: null,
                state: null,
                city: null,
                availability: null,
                graduated_at: null,
                sexes: [
                    { value: 0, text: 'Mujer' },
                    { value: 1, text: 'Hombre' }
                ],
                dropzoneOptions: {
                    thumbnailWidth: 110,
                    thumbnailHeight: 110,
                    dictDefaultMessage: 'Agrega una imagen como foto de perfil'
                }
            }
        },
        methods: {
            getUser() {
                axios.get('api/user')
                    .then(res => {
                        console.log(res)
                        this.name = res.data.name
                        this.desc = res.data.subtitle
                        this.age = res.data.age
                        this.dob = res.data.dob
                        this.university = res.data.university
                        this.major = res.data.major
                        this.foi = res.data.foi
                        this.sex = res.data.sex
                        this.student_type = res.data.student_type
                        this.pic_url = res.data.pic_url
                        this.state = res.data.state
                        this.city = res.data.city
                        this.cellphone = res.data.cellphone
                        this.availability = res.data.availability
                        this.graduated_at = res.data.graduated_at
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            selectSex(sex) {
                this.sex = sex
                this.sendForm()
            },
            selectType(type) {
                this.student_type = type
                this.sendForm()
            },
            sendForm() {
                let data = {
                    name: this.name,
                    cellphone: this.cellphone,
                    desc: this.desc,
                    age: this.dob,
                    university: this.university,
                    major: this.major,
                    foi: this.foi,
                    sex: this.sex.value,
                    availability: this.availability,
                    state: this.state,
                    city: this.city,
                    graduated_at: this.graduated_at,
                }

                axios.post('api/user/details', data)
                    .then(res => {
                        //
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            showSuccess() {
                console.log('A file was successfully uploaded')
                this.getUser()
            }
        },
        mounted () {
            console.log(this.url)
            this.getUser()
        },
        components: {
            BasicSelect,
            Dropzone
        }
    }
</script>