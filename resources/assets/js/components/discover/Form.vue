<template>

    <div>

        <div class="col-xs-12 card horizontal">
            <form class="form-inline">
                <div class="row form">
                    <div class="col-sm-6 col-xs-12">
                        <div class="form-group">
                            <input type="text" name="keywords" class="form-control" placeholder="Palabras clave" autofocus
                                   :value="data.keywords">
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <div class="form-group">
                            <basic-select :options="sexes"
                                          :selected-option="sex"
                                          placeholder="Sexo"
                                          @select="selectSex"></basic-select>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <div class="form-group">
                            <input class="form-control" type="text" name="location" v-model="data.location" placeholder="Localización">
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-4">
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="data.availability" placeholder="Disponibilidad">
                            <!-- <basic-select :options="students"
                                          :selected-option="student"
                                          placeholder="Tipo de estudiante"
                                          @select="selectStudent"></basic-select> -->
                        </div>
                    </div>
                </div>
                <div class="row form">
                    <div class="col-sm-6 col-xs-12">
                        <div class="col-sm-3 col-xs-6 no-left-padding">
                            <div class="form-group">
                                <input type="number" class="form-control" name="age_min" placeholder="Edad mínima" min="0"  step="1"
                                    :value="data.age_min"
                                    :max="data.age_max">
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6 no-right-padding-xs">
                            <div class="form-group">
                                <input type="number" class="form-control" name="age_max" placeholder="Edad máxima" max="100" step="1"
                                    :min="data.age_min"
                                    :value="data.age_max">
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 no-right-padding no-left-padding-xs">
                            <div class="form-group">
                                <input type="text" class="form-control" v-model="data.major" placeholder="Carrera">
                                <!-- <basic-select :options="majors"
                                              :selected-option="major"
                                              placeholder="Carrera"
                                              @select="selectMajor"></basic-select> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <input class="form-control" type="text" v-model="data.university" placeholder="Universidad">
                            <!-- <basic-select :options="universities"
                                          :selected-option="university"
                                          placeholder="Universidad"
                                          @select="selectUniversity"></basic-select> -->
                        </div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="form-group">
                            <input class="form-control" type="text" v-model="data.foi" placeholder="Campo de interés">
                            <!-- <basic-select :options="fois"
                                          :selected-option="foi"
                                          placeholder="Field of interest"
                                          @select="selectFoi"></basic-select> -->
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

            <div v-for="student of results" class="student">
                <a :href="student.url">
                    <div class="row">
                        <div class="col-xs-5 student__avatar no-padding">
                            <img v-if="student.avatar" :src="student.avatar">
                        </div>
                        <div class="col-xs-7 student__details">
                            <p class="title" v-text="student.name"></p>
                            <p v-text="student.foi"></p>
                            <hr>
                            <p>
                                <i class="fa fa-university"></i>
                                {{ student.university }}
                            </p>
                            <p>
                                <i class="fa fa-graduation-cap"></i>
                                {{ student.major }}
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
      data () {
        return {
            data: {
                keywords: null,
                age_min: null,
                age_max: null,
            },
            last_page: null,
            previous_page: null,
            current_page: null,
            next_page: null,
            sexes: [
                { value: '0', text: 'Female' },
                { value: '1', text: 'Male' },
            ],
            universities: [
                { value: 0, text: 'Select a college' },
            ],
            students: [
                { value: 0, text: 'Full time student' },
                { value: 1, text: 'Internship' },
                { value: 2, text: 'Part time' },
                { value: 3, text: 'Full time work' },
            ],
            majors: [
                { value: null, text: 'Selecciona una universidad' },
            ],
            fois: [
                { value: 0, text: 'Loading...' },
            ],
            searchText: '',
            sex: { value: '', text: '' },
            university: { value: '', text: '' },
            student: { value: '', text: '' },
            major: { value: '', text: '' },
            foi: { value: '', text: '' },
            students: null,
            results: [],
        }
      },
      methods: {
        selectSex (item) {
            this.sex = item
            this.data.sex = item.value
        },
        selectStudent (item) {
            this.student = item
            this.data.student = item.value
        },
        selectFoi (item) {
            this.foi = item
            this.data.foi = item.value
        },
        sendForm (page) {
            console.log(this.data)
            axios.post('/api/user/search' + page, this.data)
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
        }
      },
      mounted() {

      },
      components: {
        BasicSelect
      }
    }
</script>
