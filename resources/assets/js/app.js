
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
moment = require('moment');

window.Event = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('offer-list', require('./components/Offers.vue'));
Vue.component('offer-card', require('./components/Offer.vue'));

Vue.component('company-dashboard', require('./components/company/Dashboard.vue'));
Vue.component('company-bio', require('./components/company/Bio.vue'));
Vue.component('company-striped', require('./components/company/Striped.vue'));
Vue.component('bio-updateModal', require('./components/company/BioModal.vue'));

Vue.component('chat-list', require('./components/chats/AllChats.vue'));
Vue.component('chat-detail', require('./components/chats/Chat.vue'));
Vue.component('chat-message', require('./components/chats/Message.vue'));
Vue.component('single-chat', require('./components/chats/SingleChatComponent.vue'));

Vue.component('discover-form', require('./components/discover/Form.vue'));
Vue.component('discover-results', require('./components/discover/Results.vue'));

Vue.component('student-featured', require('./components/student/Featured.vue'));
Vue.component('student-applied', require('./components/student/Applied.vue'));
Vue.component('student-cv', require('./components/student/Curriculum.vue'));

Vue.component('student-work', require('./components/student/Work.vue'));
Vue.component('student-discover', require('./components/discover/StudentDiscover.vue'));

Vue.component('dismissable-alert', require('./components/Alert.vue'));
// Vue.component('loading-block', require('./components/Loading.vue'));

// Vue.component('clip-loader', require('vue-spinner/src/ClipLoader.vue'));
// Vue.component('form-generator', require('vue-form-generator/src/formGenerator.vue'));

// start
    Vue.component('start-details', require('./components/start/Details.vue'));
    Vue.component('start-featured', require('./components/start/Featured.vue'));
    Vue.component('start-work', require('./components/start/WorkExperience.vue'));
    Vue.component('start-education', require('./components/start/Education.vue'));
    Vue.component('start-social', require('./components/start/Social.vue'));
    Vue.component('start-skill', require('./components/start/Skill.vue'));

// Offers
    Vue.component('offer-socials', require('./components/offers/Socials.vue'));
    Vue.component('offer-modal', require('./components/offers/FormModal.vue'));

Vue.filter('formatDate', function(value) {
  if (value) {
    return moment(String(value)).format('MM/DD/YYYY')
  }
});

const app = new Vue({
    el: '#app',

    data: {
        menuHidden: true,
    },

    methods: {
        getChat(chat_id) {
            alert(chat_id)
        }
    },
    created() {

    }
});
