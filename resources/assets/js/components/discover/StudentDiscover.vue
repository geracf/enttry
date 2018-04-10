<template>

    <div class="loquilla">

        <div class="col-xs-12 card horizontal">

            <form class="form-inline">
                <div class="row form">

                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Palabras clave" autofocus v-model="data.keywords">
                        </div>
                    </div>

                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Localizacion" v-model="data.location">
                        </div>
                    </div>

                </div>

                <div class="row form">
                    <div class="col-sm-4 col-xs-6">
                        <div class="form-group">
                            <basic-select :options="looking_for"
                                          :selected-option="looking"
                                          placeholder="Tipo"
                                          @select="selectLooking"></basic-select>
                        </div>
                    </div>

                    <div class="col-sm-4 col-xs-6">
                        <div class="form-group">
                            <basic-select :options="remote_types"
                                          :selected-option="remote"
                                          placeholder="Trabajo remoto"
                                          @select="selectRemote"></basic-select>
                        </div>
                    </div>

                    <div class="col-sm-4 col-xs-6">
                        <div class="form-group">
                            <basic-select :options="categories"
                                          :selected-option="category"
                                          placeholder="Categoría"
                                          @select="selectCategory"></basic-select>
                        </div>
                    </div>

                </div>

                <div class="row form">
                    <div class="col-sm-12 col-xs- clearfix">
                        <a @click="sendForm('?page=1')" class="btn btn-primary pull-right"><i class="fa fa-search"></i></a>
                    </div>
                </div>
            </form>

        </div>

        <div class="col-xs-12 no-left-padding">

            <div v-for="offer of results" class="student">
                <a :href="offer.url">
                    <div class="row">
                        <div class="col-xs-5 student__avatar no-padding">
                            <img v-if="offer.img_url" :src="offer.img_url">
                        </div>
                        <div class="col-xs-7 student__details">
                            <p class="title" v-text="offer.name"></p>
                            <p v-text="offer.desc"></p>
                            <hr>
                            <p>
                                <i class="fa fa-building-o"></i>
                                {{ offer.company_name }}
                            </p>
                            <p v-if="!offer.can_apply">
                                <i class="fa fa-check"></i>
                                Ya aplicaste a esta oferta
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="fab-container">
                <div class="fab" v-if="previous_page" @click="getPreviousPage()">
                    <i class="fa fa-caret-left fa-2x"></i>
                </div>
                <div class="fab" v-if="next_page" @click="getNextPage()">
                    <i class="fa fa-caret-right fa-2x"></i>
                </div>
            </div>

        </div>

    </div>

</template>

<script>
    import { BasicSelect } from 'vue-search-select'

    export default {
        data() {
            return {
                results: [],
                last_page: null,
                previous_page: null,
                current_page: null,
                next_page: null,
                data: {
                    keywords: null,
                    looking: null,
                    remote: null,
                    cetegory: null,
                },
                looking_for: [
                    { value: 'Estudiante', text: 'Estudiante' },
                    { value: 'Practicante', text: 'Practicante' },
                    { value: 'Graduado', text: 'Graduado' },
                    { value: 'Recién graduado', text: 'Recién graduado' },
                ],
                looking: { value: null, text: null },
                remote_types: [
                    { value: true, text: 'Remoto' },
                    { value: false, text: 'Presencial' },
                ],
                remote: { value: null, text: null },
                categories: [
                    { value: 'full-time', text: 'Tiempo completo' },
                    { value: 'internship', text: 'Prácticas' },
                    { value: 'part-time', text: 'Medio tiempo' },
                ],
                category: { value: null, text: null },
            }
        },
        methods: {
            selectLooking(looking) {
                this.looking = looking
                this.data.looking = this.looking.value
            },
            selectRemote(remote) {
                this.remote = remote
                this.data.remote = this.remote.value
            },
            selectCategory(category) {
                this.category = category
                this.data.category = this.category.value
            },
            sendForm (page) {
                axios.post('/api/offer/search' + page, this.data)
                    .then(res => {
                        this.handlePages(res.data)
                        this.results = res.data.data
                        console.log(res.data.data)
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getNextPage() {
                this.sendForm('?page=' + this.next_page)
            },
            getPreviousPage() {
                this.sendForm('?page=' + this.previous_page)
            },
            handlePages(res) {
                this.current_page = res.current_page
                this.last_page = res.last_page

                if (this.current_page < this.last_page) {
                    this.next_page = this.current_page + 1
                } else {
                    this.next_page = null
                }

                if (this.current_page != 1) {
                    this.previous_page = this.current_page - 1
                } else {
                    this.previous_page = null
                }
            },
        },
        mounted() {

        },
        components: {
            BasicSelect
        }
    }
</script>

<style>

    .loquilla {
        min-height: 300px;
        margin-bottom: 100px;
    }

</style>