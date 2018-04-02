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

        axios.post(API_MY_BASIC_URL + 'login', {
            'email': email,
            'password': password
        })
        .then(data => {
            let responseData = data.data;

            if(responseData.success && responseData.data.token) {

                localStorage.setItem('token', responseData.data.token);
                localStorage.setItem('liveTimeToken', (new Date).setMinutes(responseData.data.tokenTime));
                commit('_setAuthUser', responseData.user);
                commit('setAuthFlag', true);

                /* TODO брать new Date, а потом добавлять 
                 * tokenTime и проверять каждый раз в App не вышло ли время токена */
            } else {
                throw new Error('User not found', 404);
            }
        })
        .catch(ex => console.log(ex.message));

    }
}

const mutations = {
    _setAuthUser (state, {name, email, avatar, token}) {
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