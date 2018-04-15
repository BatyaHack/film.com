import axios from 'axios';
import {API_MY_BASIC_URL} from '@/config.js'

const state = {
    isLogin: false,
    user: {
        name: '',
        email: '',
        avatar: '',
        token: '',
        tokenTime: '',
    }
}

const getters = {
    getUserLogin: function (state) {
        return state.user;
    },
    isUserLogin: function (state) {
        return state.isLogin;
    }
}

const actions = {
    loginFromForm({commit, state}, {email, password}) {

        return axios.post(API_MY_BASIC_URL + 'login', {
            email: email,
            password: password
        })
        .then(data => {
            let responseData = data.data;

            if(responseData.success && responseData.data.token) {

                localStorage.setItem('token', `Bearer ${responseData.data.token}`);
                localStorage.setItem('liveTimeToken', (new Date).setMinutes(responseData.data.tokenTime));
                commit('_setAuthUser', responseData);
                commit('setAuthFlag', true);

                /* TODO брать new Date, а потом добавлять 
                 * tokenTime и проверять каждый раз в App не вышло ли время токена */
            } 
            return data;
        })
        .catch(ex => console.log(ex.message));

    },
    registration({commit, state}, { name, email, password }) {

        return axios.post(API_MY_BASIC_URL + 'register', {
            name: name,
            email: email,
            password: password
        })
        .then(data => {
            console.log(data.data)
        })
    },
    getAuthUser({commit, state}, token) {

        return axios.get(API_MY_BASIC_URL + 'checkToken', {
            headers: {
                Authorization: token
            }
        })
        .then(data => {
            let responseData = data.data;
            responseData.data = {
                token: token
            };
            if(responseData.success) {
                commit('_setAuthUser', responseData);
                commit('setAuthFlag', true);
            }
        })
        .catch(ex => console.log(ex))
    }
}

const mutations = {
    _setAuthUser (state, { data : {token}, user : {name, email, avatar}}) {
        state.user.name = name;
        state.user.email = email;
        state.user.avatar = avatar;
        state.user.token = token;
    },
    setAuthFlag (state, isLogin) {
        state.isLogin = isLogin;
    }
}

export default {
    state,
    getters,
    actions,
    mutations,
}