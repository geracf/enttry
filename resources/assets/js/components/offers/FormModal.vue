<template>

    <div class="modal fade" tabindex="-1" role="dialog" id="addOffer">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar {{ offer.name }}</h4>
                </div>

                <form id="addOfferForm" method="post" :action="action" enctype="multipart/form-data">

                    <input type="hidden" name="_token" :value="token">
                    <input type="hidden" name="_method" :value="method">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input class="form-control" type="text" name="name" placeholder="Ponle un nombre a tu oferta" v-model="offer.name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Categoría</label>
                                    <input class="form-control" type="text" name="category" placeholder="IT, Inverstigación, HR?" v-model="offer.category">
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label>Tipo de oferta</label>
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
                                    <label>Salario</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        <input type="text" class="form-control" id="exampleInputAmount" name="salary" placeholder="Cantidad ofertada" v-model="offer.salary">
                                        <div class="input-group-addon">.00 MXN</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <label>Localización</label>
                                    <input class="form-control" type="text" name="location" placeholder="¿Dónde van a trabajar?" v-model="offer.location">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <input type="hidden" name="lat" id="formLat">
                                <input type="hidden" name="lng" id="formLng">
                                <div id="modal-map"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" name="show_location" value="0">
                                            <input type="checkbox" name="show_location" checked="checked" value="1"> Mostrar pin en el mapa
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="hidden" name="remote" value="0">
                                            <input type="checkbox" name="remote" value="1"> Puede trabajar de forma remota
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Descripción del trabajo</label>
                                    <textarea class="form-control" name="desc" placeholder="What can they expect from this job?" v-model="offer.desc"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Requerimientos</label>
                                    <div>
                                        <span v-for="requirement of offer.requirements">
                                            <input type="hidden" name="requirements[]" :value="requirement.text">
                                            <span class="badge" v-text="requirement.text"></span>
                                            <span class="badge btn-danger" @click="removeRequirement(requirement)">
                                                <i class="fa fa-times"></i>
                                            </span>
                                        </span>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Escribe y presiona Enter" v-model="new_requirement" @keyup.enter="addRequirement">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <h3>Opcionales</h3>

                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Pregunta 1</label>
                                    <input class="form-control" type="text" name="question[]" placeholder="Lo que quieras preguntar" v-model="offer.questions[0].text">
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Pregunta 2</label>
                                    <input class="form-control" type="text" name="question[]" placeholder="Lo que quieras preguntar" v-model="offer.questions[1].text">
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label>Pregunta 3</label>
                                    <input class="form-control" type="text" name="question[]" placeholder="Lo que quieras preguntar" v-model="offer.questions[2].text">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="submitOffer">Editar oferta</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: {
            action: {
                type: String,
                default: null,
            },
            is_student: {
                type: Boolean,
                default: true,
            },
            method: {
                type: String,
                default: 'post',
            },
            token: {
                type: String,
                default: null
            },
            id: Number
        },
        data() {
            return {
                new_requirement: null,
                requirements: [],
                offer: {
                    questions: [
                        { text: null },
                        { text: null },
                        { text: null },
                    ],
                    requirements: []
                },
                lat: -12,
                lng: -77,
            }
        },
        mounted() {
            let lat = this.lat
            let lng = this.lng
            let needs_geocoding = false;
            console.log(lat, lng)

            axios.get('/api/offer/'+ this.id)
                .then(res => {
                    this.offer = res.data

                    console.log(this.offer)

                    lat = this.offer.lat
                    lng = this.offer.lng

                    // console.log(this.offer, lng)

                    if (lat === null || lng === null) {
                        needs_geocoding = true
                    }

                    while(this.offer.questions.length <= 3) {
                        this.offer.questions.push({ text: null })
                    }
                })
                .catch(err => {
                    console.log(err)
                })
            $('#addOffer').on('shown.bs.modal', function () {
                if (needs_geocoding) geocodeMap()
                else initMap()
            })

            var initMap = function () {

                let map = new GMaps({
                    div: '#modal-map',
                    lat: lat,
                    lng: lng,
                })

                // console.log(lat, lng)

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

            }

            var geocodeMap = function () {
                GMaps.geolocate({
                  success: function(position) {
                    lat = position.coords.latitude
                    lng = position.coords.longitude

                    console.log(lat, lng)

                    $('#formLat').val(lat)
                    $('#formLng').val(lng)

                    initMap()

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
            }
        },
        methods: {
            addRequirement() {
                this.offer.requirements.push({text: this.new_requirement})
                this.new_requirement = null
            },
            removeRequirement(requirement) {
                this.requirements.splice(this.requirements.indexOf(requirement), 1)
            },
            submitOffer() {
                $('#addOfferForm').submit();
            }
        }
    }
</script>