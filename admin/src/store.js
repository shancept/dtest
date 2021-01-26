import Vue from 'vue'
import Vuex from 'vuex'
import {getToken, objectMerge} from './helpers/helper'
import Axios from 'axios'
import { Loading } from 'element-ui';
import { Notification } from 'element-ui';

Vue.use(Vuex);

dataStore = objectMerge(dataStore, {
    state: {
        formVisible: false,
        formUpdate: {},
        feedback: {
            list: [],
            attributeLabels: {}
        },
        profiler: {
            list: [],
            attributeLabels: {}
        },
        log: {
            list: [],
            attributeLabels: {}
        },
    },
    getters: {},
    mutations: {
        set(state, {type, data}) {
            state[type] = data;
        },
        setTo(state, {type, key, data}) {
            state[type][key] = data;
        },
        updateSet(state, {type, key, item}) {
            state[type][key]['value'] = item;
        },
        updateState(state, {type, name, key, item}) {
            try {
                state[type][name][key]['value'] = item;
            } catch (e) {
                console.log(e);
                Notification.error({
                    title: 'Ошибка',
                    message: e.message,
                })
            }
        },
        updateRoute(state, {index, key, value}) {
            state['route']['list'][index][key] = value;
        },
        update(state, {type, key, item}) {
            state[type][key] = item;
        },
        push(state, {type, item}) {
            state[type].push(item);
        },
        delete(state, {type, key}) {
            state[type].splice(key, 1);
        },
        insert(state, {type, key, data}) {
            state[type].splice(key, 0, data);
        },
        swap(state, {type, key1, key2}) {
            state[type][key1] = [state[type][key2], state[type][key2] = state[type][key1]][0];
            state[type].splice(key1, 1, state[type][key1]);
        },
    },
    actions: {
        getData({commit}, data) {
            let loadingInstance = Loading.service({fullscreen: true});
            Axios({
                url: '/api/'+data+'?access-token=' + getToken()
            }).then(res => {
                if (res.data.code === 200) {
                    commit('setTo', {type: data, key: 'list', data: res.data.result.list});
                    if(typeof res.data.result.attributeLabels !== 'undefined') {
                        commit('setTo', {type: data, key: 'attributeLabels', data: res.data.result.attributeLabels});
                    }
                }
                loadingInstance.close();
            }).catch(() => loadingInstance.close());
        },
    }
});

export default new Vuex.Store(dataStore)
