<template>

    <div class="row featured-work">
        <div class="title">
            <h1>My best work</h1>
        </div>

        <div class="featured-work__container">

            <p v-if="projects.length <= 0">Add something to show!</p>
            <!-- <div v-else v-for="project in projects">
                {{ project }}
            </div> -->

        </div>

    </div>

</template>

<script>
    export default {
        data () {
            return {
                projects: [],
            }
        },
        mounted () {
            this.getProjects()
        },
        methods: {
            getProjects() {
                axios.get('api/featured')
                    .then(res => {
                        console.log(res.data)
                        this.projects = res.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        }
    }
</script>

<style>
    .default {
        margin: 10px;
    }
</style>