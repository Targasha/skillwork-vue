import Vue from 'vue';
import Vuex from 'vuex';

import auth from '../_services/auth-service';
import alert from './alert-module';
import articleService from "../_services/article-service";
import registerService from "../_services/register-service";

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        auth,
        alert,
        articleService,
        registerService
    }
});
