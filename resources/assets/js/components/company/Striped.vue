<template>
    <div class="card horizontal striped">
        <h4 v-if="title" v-text="title"></h4>
        <table class="table table-responsive table-hover table-condensed">
            <thead v-if="list.headers">
                <tr>
                    <th v-for="header in list.headers" v-text="header.title" :class="{ 'text-right' : header.right }"></th>
                </tr>
            </thead>
            <tbody>

                <tr v-if="list.data.length > 0" v-for="row in list.data">
                    <td v-html="row.tag"></td>
                    <td v-if="isValidNumberOrString(row.body)" v-text="row.body" class="text-right"></td>
                    <td v-else-if="isEmptyString(row.body)" class="text-right">Not available</td>
                    <td v-else-if="isNull(row.body)" class="text-right">Not set</td>
                </tr>
                <tr v-if="list.data.length <= 0">
                    <td colspan="2" v-text="empty_text"></td>
                </tr>

            </tbody>

        </table>

        <a v-if="hasButton" :href="action" class="btn btn-block btn-success">
            Ver planes
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            title: String,
            list: Object,
            empty_text: String,
            hasButton: {
                type: Boolean,
                default: false,
            },
            action: String,
        },
        methods: {
            isValidNumberOrString: function(body) {
                return (typeof body === 'number' || (typeof body === 'string' && body.length > 0))
            },
            isNull: function() {
                return (typeof body === 'undefined')
            },
            isEmptyString: function() {
                return (typeof body === 'string' && body.length == 0)
            }
        }
    }
</script>
