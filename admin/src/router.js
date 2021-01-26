import Vue from 'vue'
import Router from 'vue-router'
import store from './store.js'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import(/* webpackChunkName: "home" */ './views/Sets.vue'),
      props: { sets: store.state.siteSets, title: 'Настройки сайта', type: 'siteSets' }
    },
    {
      path: '/route',
      name: 'route',
      component: () => import(/* webpackChunkName: "route" */ './views/Route.vue')
    },
    {
      path: '/mail',
      name: 'mail',
      component: () => import(/* webpackChunkName: "mail" */ './views/Sets.vue'),
      props: { sets: store.state.mailSets, title: 'Настройка почты', type: 'mailSets' }
    },

    {
      path: '/general',
      name: 'general',
      component: () => import(/* webpackChunkName: "general" */ './views/Sets.vue'),
      props: { sets: store.state.generalPageSets, title: 'Главная', type: 'generalPageSets' }
    },
    {
      path: '/terminal_services',
      name: 'terminal_services',
      component: () => import(/* webpackChunkName: "terminal_services" */ './views/Sets.vue'),
      props: { sets: store.state.terminalServicesPageSets, title: 'Терминальные услуги', type: 'terminalServicesPageSets' }
    },
    {
      path: '/groupage_cargo',
      name: 'groupage_cargo',
      component: () => import(/* webpackChunkName: "groupage_cargo" */ './views/Sets.vue'),
      props: { sets: store.state.groupageCargoPageSets, title: 'Сборный груз', type: 'groupageCargoPageSets' }
    },
    {
      path: '/refrigerator',
      name: 'refrigerator',
      component: () => import(/* webpackChunkName: "refrigerator" */ './views/Sets.vue'),
      props: { sets: store.state.refrigeratorPageSets, title: 'Рефрижераторные перевозки', type: 'refrigeratorPageSets' }
    },
    {
      path: '/about',
      name: 'about',
      component: () => import(/* webpackChunkName: "about" */ './views/Sets.vue'),
      props: { sets: store.state.aboutPageSets, title: 'О компании', type: 'aboutPageSets' }
    },
    {
      path: '/city',
      name: 'city',
      component: () => import(/* webpackChunkName: "city" */ './views/City.vue')
    },
    {
      path: '/profiler',
      name: 'profiler',
      meta: { title: 'Профайлер' },
      component: () => import(/* webpackChunkName: "log" */ './views/Log.vue')
    },
    {
      path: '/log',
      name: 'log',
      meta: { title: 'Логи' },
      component: () => import(/* webpackChunkName: "log" */ './views/Log.vue')
    },
    {
      path: '/feedback',
      name: 'feedback',
      meta: { title: 'Обратная связь' },
      component: () => import(/* webpackChunkName: "feedback" */ './views/Feedback.vue')
    },
  ]
})
