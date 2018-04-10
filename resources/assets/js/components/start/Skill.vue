<template>
    <div class="row">
        <div class="col-sm-4">
            <h4>
                Idiomas
                <a class="pull-right" @click="addLanguage">
                    <i class="fa fa-plus"></i>
                </a>
            </h4>
            <ul v-if="languages.length > 0">
                <li v-for="language in languages">
                    {{ language.title }} ({{ language.development }})
                    <i class="fa fa-times text-danger pull-right" @click="deleteSkill(language)"></i>
                </li>
            </ul>
            <p v-else>Agrega alguno</p>
        </div>
        <div class="col-sm-4">
            <h4>
                Habilidades Técnicas
                <a class="pull-right" @click="addTech">
                    <i class="fa fa-plus"></i>
                </a>
            </h4>
            <ul v-if="tech_skills.length > 0">
                <li v-for="tech in tech_skills">
                    {{ tech.title }}
                    <i class="fa fa-times text-danger pull-right" @click="deleteSkill(tech)"></i>
                </li>
            </ul>
            <p v-else>Agrega alguno</p>
        </div>
        <div class="col-sm-4">
            <h4>
                Habilidades Suaves
                <a class="pull-right" @click="addSoft">
                    <i class="fa fa-plus pull-right"></i>
                </a>
            </h4>
            <ul v-if="soft_skills.length > 0">
                <li v-for="soft in soft_skills">
                    {{ soft.title }}
                    <i class="fa fa-times text-danger pull-right" @click="deleteSkill(soft)"></i>
                </li>
            </ul>
            <p v-else>Agrega alguno</p>
        </div>

        <!-- Modals -->
        <div id="languageModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Agregar lenguaje</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Lenguage</label>
                                <input class="form-control" type="text" v-model="post.title" placeholder="¿Que idioma sabes?">
                            </div>
                            <div class="form-group">
                                <label>Nivel</label>
                                <input class="form-control" type="text" v-model="post.development" placeholder="¿Cuál es tu nivel?">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="postSkill">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="techModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Agregar habilidad técnica</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Habilidad</label>
                                <input class="form-control" type="text" v-model="post.title" placeholder="¿Que puedes hacer?">
                            </div>
                            <div class="form-group">
                                <label>Nivel</label>
                                <input class="form-control" type="text" v-model="post.development" placeholder="¿Cuál es tu nivel?">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" @click="postSkill">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="softModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Agregar habilidad suave</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label>Habilidad Suave</label>
                                <input class="form-control" type="text" v-model="post.title" placeholder="¿Que sabes hacer?">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="postSkill">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        data() {
            return {
                languages: [],
                tech_skills: [],
                soft_skills: [],
                post: {
                    type: null,
                    title: null,
                    development: null,
                }
            }
        },
        methods: {
            addLanguage() {
                this.post.type = 'language'
                $('#languageModal').modal('toggle')
            },
            addTech() {
                this.post.type = 'technical'
                $('#techModal').modal('toggle')
            },
            addSoft() {
                this.post.type = 'soft'
                $('#softModal').modal('toggle')
            },
            postSkill() {
                console.log('ok?')
                axios.post('api/skills', this.post)
                    .then(res => {
                        this.resetModal()
                        this.getSkill()
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            getSkill() {
                axios.get('api/skills')
                    .then(res => {
                        this.languages = res.data.languages
                        this.tech_skills = res.data.tech_skills
                        this.soft_skills = res.data.soft_skills
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            deleteSkill(skill) {
                let data = {
                    _method: 'DELETE',
                }
                axios.post('api/skills/' + skill.id, data)
                    .then(res => {
                        this.getSkill()
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            resetModal() {
                if (this.post.type == 'language') {
                    this.addLanguage()
                } else if (this.post.type == 'technical') {
                    this.addTech()
                } else {
                    this.addSoft()
                }
                this.post = {
                    type: null,
                    title: null,
                    development: null,
                }
            }
        },
        mounted() {
            this.getSkill()
        }
    }
</script>