import axios from 'axios';
import {API_MY_BASIC_URL} from '@/config.js'

const state = {
    user: {
        name: '',
        email: '',
        avatar: '',
        token: '',
        tokenTime: '',
    }
}

const getters = {
    user: function (state) {
        return state.user;
    }
}

const actions = {
    loginFromForm({commit, state}, {email, password}) {
        
        console.log(email);
        console.log(password);

        axios.post(API_MY_BASIC_URL + 'login', {
            'email': email,
            'password': password
        })
        .then(data => {
            let responseData = data.data;

            if(responseData.success && responseData.data.token) {
                localStorage.setItem('token', responseData.data.token);
                localStorage.setItem('tokenTime', responseData.data.tokenTime);
                // commit('setAuthUser')
                /* TODO брать new Date, а потом добавлять 
                 * tokenTime и проверять каждый раз в App не вышло ли время токена */
            }
        })
        .catch(ex => console.log(ex.message));

    }
}

const mutations = {
    setAuthUser (state, {name, email, avatar, token}) {
        state.name = name;
        state.email = email;
        state.avatar = avatar;
        state.token = token;
    }
}

export default {
    state,
    getters,
    actions,
    mutations,
}