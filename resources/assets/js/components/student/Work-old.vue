<template>
    <div class="row featured-work">
        <div class="title">
            <h1>
                My best work
            </h1>
        </div>
        <div style="margin-left: 15px;" class="col-xs-12 card no-padding">
            <a class="btn btn-default btn-add pull-right" @click="formVisible = !formVisible">
                Add project
                <i :class="[ formVisible ? 'fa-minus' : 'fa-plus' ]" class="fa"></i>
            </a>
            <div class="row no-padding">
                <div class="col-xs-12 no-padding">
                    <p class="default" v-if="projects.length <= 0">Agrega algún proyecto</p>
                    <div :class="{ 'extended' : formVisible }" class="row no-padding featured-work__wrapper">
                        <div v-for="project of projects" class="col-xs-12 col-sm-5 featured-work__container">
                            <div class="featured-work__image">
                                <img class="img-responsive" :src="project.thumbnail">
                            </div>
                            <div class="featured-work__contents">
                                <h5 v-text="project.feature_name"></h5>
                                <p>{{ project.release_date | formatDate }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" v-if="formVisible" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                formVisible: false,
                projects: [],
                form: {
                    feature_name: null,
                    feature_url: null,
                    technologies_used: null,
                    desc: null,
                    release_date: null,
                    picture: null,
                }
            }
        },
        mounted () {
            this.getProjects()
        },
        methods: {
            addProject() {
                console.log('addProject')
            },
            getProjects() {
                axios.get('api/featured')
                    .then(res => {
                        console.log(res.data)
                        this.projects = res.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length) return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.form.picture = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            storeProject() {
                axios.post('api/featured', this.form)
                    .then(res => {
                        console.log(res)
                        this.getProjects()
                    })
                    .catch(err => {
                        console.log(err)
                    })
                console.log(this.form)
            }
        }
    }
</script>

<style>
    .default {
        margin: 10px;
    }
</style>