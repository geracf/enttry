<template>
    <div class="col-xs-12 start__card">
        <div class="row">
            <p style="display: inline-block;" class="small">Intercambios, otros estudios</p>
            <a href="#" class="btn btn-xs btn-primary pull-right"
                @click="openModal()">
                <i class="fa fa-plus"></i>
                Agregar
            </a>
        </div>

        <div class="col-xs-10 project" v-for="course of education">
            <i class="fa fa-times text-danger delete-button" @click="deleteWork(course.id)"></i>
            <a :href="course.feature_url" v-text="course.where"></a>
            <p class="small">
                <span class="strong">Desde:</span> {{ course.from }}
                <span class="strong">hasta: </span> {{ course.to }}
            </p>
            <p class="small"><span class="strong">Descripción:</span> {{ course.degree }}</p>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="addEducation">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Agregar educación</h4>
                    </div>
                    <div class="modal-body">

                        <p class="text-warning">Todos los campos son obligatorios.</p>

                        <div v-if="error" class="alert alert-danger">
                            <p v-for="e in error" v-text="e"></p>
                        </div>

                        <form>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Nombre de la institución</label>
                                        <input type="text" class="form-control" v-model="new_education.school_name" placeholder="Nombre de la institución">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Página web de la institución</label>
                                        <input type="url" class="form-control" v-model="new_education.school_website" placeholder="Página web de la institución">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Campo de estudio</label>
                                        <input type="text" class="form-control" v-model="new_education.degree" placeholder="Campo de estudio">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Fecha de inicio</label>
                                        <input type="date" class="form-control" v-model="new_education.start_date">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Fecha de término</label>
                                        <input type="date" class="form-control" v-model="new_education.end_date">
                                    </div>
                                </div>
                            </div>

                            <div class="checkbox">
                                <label>
                                    <input v-model="new_education.current" type="checkbox" value="true">
                                    Aún estoy haciendolo!
                                </label>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <label>Logros</label>
                                    <textarea class="form-control" placeholder="Dinos todo!" v-model="new_education.achivements"></textarea>
                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="postEducation">Guardar</button>
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
                education: [],
                new_education: {
                    school_name: null,
                    school_website: null,
                    degree: null,
                    technologies_used: null,
                    achivements: null,
                    start_date: null,
                    end_date: null,
                    current: false,
                },
                error: null,
            }

        },

        methods: {
            getEducation() {
                axios.get('api/education')
                    .then(res => {
                        this.education = res.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            postEducation() {
                this.error = null
                let data = {
                    school_name: this.new_education.school_name,
                    school_website: this.new_education.school_website,
                    school_website: this.new_education.school_website,
                    degree: this.new_education.degree,
                    technologies_used: this.new_education.technologies_used,
                    achivements: this.new_education.achivements,
                    achivements: this.new_education.achivements,
                    start_date: this.new_education.start_date,
                    end_date: this.new_education.end_date,
                    current: this.new_education.current,
                }
                axios.post('api/education', data)
                    .then(res => {
                        this.getEducation()
                        this.new_education = {}
                        $('#addEducation').modal('hide')
                        this.resetData()
                    })
                    .catch(err => {
                        this.error = err.response.data
                        console.log(err)
                    })
            },
            deleteWork(education_id) {

                let data = {
                    _method: 'delete'
                }

                axios.post('api/education/' + education_id, data)
                    .then(res => {
                        this.getEducation()
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            openModal() {
                $('#addEducation').modal('toggle')
            },
            resetData() {
                this.new_education = {
                    school_name: null,
                    school_website: null,
                    degree: null,
                    technologies_used: null,
                    achivements: null,
                    start_date: null,
                    end_date: null,
                    current: false,
                }
            }
        },
        mounted() {
            this.getEducation()
        }


    }
</script>