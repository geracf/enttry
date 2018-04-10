<template>
    <div>
        <div class="row offer-list">
            <div v-if="title" class="title">
                <h1 v-text="title"></h1>
                <a v-if="can_add" class="add pull-right" href="#" @click="showAddForm">
                    <i class="fa fa-plus fa-2x"></i>
                </a>
            </div>
            <offer-card
                v-for="offer in offers"
                :key="offer.id"
                :offer="offer"
                :url="offer.url"
                :is_student="is_student">{{ offer.img_url }}</offer-card>
            <p class="no-applications" v-if="!offers || offers.length < 1" v-text="null_text"></p>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="addOffer">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Crea una oferta laboral</h4>
                    </div>

                    <form id="addOfferForm" method="post" :action="action" enctype="multipart/form-data">

                        <input type="hidden" name="_token" :value="token">

                        <div class="modal-body">

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Nombre de la oferta</label>
                                        <input class="form-control" type="text" name="name" v-model="new_offer.name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label>Categoría</label>
                                        <input class="form-control" type="text" name="category" placeholder="IT, Investigación, RH?" v-model="new_offer.category">
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label>Tipo de trabajo</label>
                                        <select name="type" class="form-control">
                                            <option value="full-time">Tiempo completo</option>
                                            <option value="internship">Prácticas profesionales</option>
                                            <option value="part-time">Medio tiempo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <label>Candidato buscado</label>
                                        <select name="looking_for" class="form-control">
                                            <option value="Estudiante">Estudiante</option>
                                            <option value="Recién graduado">Recién graduado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Salario ofertado</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">$</div>
                                            <input type="text" class="form-control" id="exampleInputAmount" name="salary" placeholder="Cantidad en MXN">
                                            <div class="input-group-addon">.00 MXN/Mes</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label>Localización</label>
                                        <input class="form-control" type="text" name="location" placeholder="¿Dónde van a trabajar?">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <input type="hidden" name="lat" id="formLat">
                                    <input type="hidden" name="lng" id="formLng">
                                    <div id="map"></div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="hidden" name="show_location" value="0">
                                                <input type="checkbox" name="show_location" checked="checked" value="1"> Mostrar localización en mapa
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="hidden" name="remote" value="0">
                                                <input type="checkbox" name="remote" value="1"> Puede ser trabajado remoto
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Descripción laboral</label>
                                        <textarea class="form-control" name="desc" placeholder="¿Que puede esperar el aplicate del trabajo?"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Imágenes</label>
                                        <input class="form-control" type="file" name="pictures[]" multiple>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Requerimientos</label>
                                        <div>
                                            <span v-for="requirement of requirements">
                                                <input type="hidden" name="requirements[]" :value="requirement">
                                                <span class="badge" v-text="requirement"></span>
                                                <span class="badge btn-danger" @click="removeRequirement(requirement)">
                                                    <i class="fa fa-times"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <input class="form-control" type="text" placeholder="Escribe uno y presiona 'Enter'" v-model="new_requirement" @keyup.enter="addRequirement">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <h3>Opcionales</h3>

                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Pregunta 1</label>
                                        <input class="form-control" type="text" name="question[]" placeholder="¿Dónde escuchaste de nuestra empresa?" v-model="new_offer.questions">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Pregunta 2</label>
                                        <input class="form-control" type="text" name="question[]" placeholder="¿Que experiencia tienes en el campo?" v-model="new_offer.questions">
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Pregunta 3</label>
                                        <input class="form-control" type="text" name="question[]" placeholder="¿Cuáles son tus hobbies?" v-model="new_offer.questions">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" v-model="new_requirement" @click="submitOffer">Crear oferta</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            title: String,
            url: {
                type: String,
                default: null
            },
            null_text: String,
            paginated: {
                type: Boolean,
                default: true,
            },
            action: {
                type: String,
                default: null,
            },
            is_student: {
                type: Boolean,
                default: true,
            },
        },
        data() {

            return {
                token: '',
                offers: [],
                can_add: false,
                new_offer: {
                    name: null,
                    category: null,
                    type: 'full-time',
                    show_location: true,
                    remote: false,
                    desc: null
                },
                requirements: [],
                new_requirement: null,
            }

        },
        methods: {
            showAddForm() {
                $('#addOffer').modal('show')
                $('#addOffer').on('shown.bs.modal', function () {

                    let lat = -12.123123
                    let lng = -12.123123

                    let map = new GMaps({
                        div: '#map',
                        lat: lat,
                        lng: lng,
                    })

                    GMaps.geolocate({
                      success: function(position) {
                        lat = position.coords.latitude
                        lng = position.coords.longitude

                        $('#formLat').val(lat)
                        $('#formLng').val(lng)

                        map.setCenter(lat, lng)
                        map.addMarker({
                            lat: lat,
                            lng: lng,
                            draggable: true,
                            dragend: function (e) {
                                lat = e.latLng.lat();
                                lng = e.latLng.lng();
                                $('#formLat').val(lat)
                                $('#formLng').val(lng)
                            }
                        })
                      },
                      error: function(error) {
                        alert('Geolocation failed: '+error.message);
                      },
                      not_supported: function() {
                        alert("Your browser does not support geolocation");
                      }
                    })
                })
            },
            getToken() {
                this.token = document.head.querySelector('meta[name="csrf-token"]').content
                console.log(this.token)
            },
            submitOffer() {
                document.getElementById('addOfferForm').submit()
            },
            addRequirement() {
                this.requirements.push(this.new_requirement)
                this.new_requirement = null
            },
            removeRequirement(requirement) {
                this.requirements.splice(this.requirements.indexOf(requirement), 1)
            },
        },
        mounted () {
            this.getToken()
            if (this.url) {
                axios.get(this.url)
                    .then(res => {
                        console.log(res.data)
                        if (typeof this.paginated === "undefined") {
                            this.offers = res.data.data
                        } else {
                            this.offers = res.data.data
                            this.can_add = res.data.params.can_add
                        }
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        }
    }
</script>