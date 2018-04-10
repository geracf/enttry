<template>

    <div v-if="visible" class="alert alert-dismissable alert--small" role="alert" :class="type">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="visible = false">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ title }}</strong> {{ body }}.
        <p v-if="actions.length > 0" class="alert__actions">
            <button class="btn btn-xs btn-default btn-action" v-for="action in actions" @click="action.callback">
                {{ action.text }}
            </button>
        </p>
    </div>

</template>

<script>
    export default {

        data() {
            return {
                visible: false,
                type: 'alert-success',
                title: null,
                body: null,
                actions: null,
            }
        },
        mounted() {
            Event.$on('alert-created', (data) => {
                this.type = data.type
                this.title = data.title
                this.body = data.body
                this.actions = data.actions
                this.visible = true
            })

            Event.$on('alert-close', () => {
                this.visible = false
            })
        }

    }
</script>

<style>
    .btn-action {
        margin: 0px 3px;
    }
</style>