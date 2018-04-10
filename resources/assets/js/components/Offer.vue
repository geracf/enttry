<template>
    <div class="offer">

        <div class="card">
            <div class="card-image">
                <img :src="offer.img_url">
            </div>
            <div class="card-content">
                <a :href="offer.url">
                    <p v-text="offer.name"></p>
                </a>
                <p>
                    <span class="company" v-text="offer.company_name"></span>
                    <i class="fa pull-right favorite-star"
                        v-if="offer.can_favorite"
                        :class="[ offer.favorited ? 'fa-star' : 'fa-star-o' ]"
                        @click="favoriteOffer(offer)"></i>
                </p>
            </div>

            <div class="card-action info-pay">
                <ul>
                    <li class="pay" v-text="offer.salary"></li>
                    <li class="address"><i class="fa fa-map-marker"></i> <span v-text="offer.location"></span></li>
                </ul>
            </div>
            <div class="card-action fixed-height">
                <p v-text="offer.desc"></p>
                <a class="btn btn-info" v-if="is_student && offer.can_apply && offer.has_questions" :href="url">
                    Ver
                </a>
                <a class="btn btn-primary" v-if="is_student && offer.can_apply && !offer.has_questions" href="#" @click="confirmApplication">
                    Aplicar
                </a>
                <a class="btn btn-success" v-if="is_student && !offer.can_apply" href="#" @click="alreadyApplied">
                    Ya aplicaste a esta oferta!
                </a>
                <a class="btn btn-info" v-if="!is_student && !offer.can_apply" :href="url">
                    Ver detalles
                </a>
            </div>
        </div>


    </div>
</template>

<script>
    export default {
        props: {
            offer: Object,
            url: {
                type: String
            },
            is_student: {
                type: Boolean,
                default: true,
            },
        },
        data() {
            return {
                favorited: false,
            }
        },
        methods: {
            favoriteOffer(offer) {
                offer.favorited = !offer.favorited

                if (offer.favorited) {
                    axios.post('api/favorite', { offer_id: offer.id })
                        .then(res => {
                            console.log(res)
                        })
                        .catch(err => {
                            console.log(err)
                        })
                } else {
                    axios.post('api/favorite/' + offer.favorite_id, { _method: 'DELETE'})
                        .then(res => {
                            console.log(res)
                        })
                        .catch(err => {
                            console.log(err)
                        })
                }
            },
            alreadyApplied() {
                let data = {
                    type: 'alert-warning',
                    title: 'Oops!',
                    body: 'Tu ya aplicaste a esta oferta',
                    actions: {},
                }
                console.log(data)
                Event.$emit('alert-created', data)
            },
            confirmApplication() {
                let data = {
                    type: 'alert-info',
                    title: 'Estás seguro?',
                    body: 'Confirma que quieres aplicar a esta oferta',
                    actions: [
                        {
                            text: 'Confirm',
                            callback: () => {
                                console.log('yeay')
                                Event.$emit('alert-close')
                                Event.$emit('show-loading')

                                let data = { offer_id: this.offer.id }

                                axios.post('api/applied', data)
                                    .then(res => {
                                        let data = {
                                            type: 'alert-success',
                                            title: 'Genial!',
                                            body: 'Ya aplicaste, mucha suerte!',
                                            actions: [],
                                        }
                                        this.offer.can_apply = false
                                        Event.$emit('hide-loading')
                                        Event.$emit('alert-created', data)
                                    })
                                    .catch(err => {
                                        Event.$emit('hide-loading')
                                        let data = {
                                            type: 'alert-danger',
                                            title: 'Oops!',
                                            body: 'Ocurrió un error, no pudimos aplicar!',
                                            actions: [],
                                        }
                                        Event.$emit('alert-created', data)
                                    })
                            }
                        },
                        {
                            text: 'Cancel',
                            callback: () => {
                                Event.$emit('alert-close')
                            }
                        }
                    ],
                }
                Event.$emit('alert-created', data)
            }
        }
    }
</script>
