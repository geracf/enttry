<template>
    <div class="singlechat-detail">
        <div class="chat-detail__conversation">
            <chat-message v-for="message in messages" :key="message.id" :message="message"></chat-message>
        </div>
        <div class="chat-detail__form">
            <textarea v-model="new_message" placeholder="Aquí tu mensaje"></textarea>
            <button @click="sendMessage">Enviar</button>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        props: {
            id: Number
        },
        data() {
            return {
                messages: [],
                new_message: null,
            }
        },
        methods: {
            getMessages() {
                axios.get('/api/chats/' + this.id)
                    .then(res => {
                        this.messages = res.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            },
            sendMessage() {
                if (this.new_message != null) {
                    let data = {
                        message: this.new_message,
                        chat_id: this.id,
                    }
                    axios.post('/api/chats', data).then(res => {
                        this.getMessages()
                        this.new_message = null
                    }).catch(err => {
                        console.log(err)
                    })
                }
            }
        },
        mounted() {
            this.getMessages()
        }
    }
</script>