<template>
  <el-aside width="215px" style="background-color: rgb(238, 241, 246)">
    <el-menu>
      <el-submenu index="1">
        <template slot="title"><i class="el-icon-s-home"></i>Главное</template>
        <a href="/"><el-menu-item index="1">На сайт</el-menu-item></a>
        <router-link to="/"><el-menu-item index="2">Настройки сайта</el-menu-item></router-link>
        <router-link to="/mail"><el-menu-item index="2">Настройка почты</el-menu-item></router-link>
        <a href="#" @click="flush"><el-menu-item index="2">Сбросить кэш</el-menu-item></a>
      </el-submenu>
      <el-submenu index="2">
        <template slot="title"><i class="el-icon-setting"></i>Настройки страниц</template>
        <router-link to="/general"><el-menu-item index="2">Главная</el-menu-item></router-link>
        <router-link to="/refrigerator"><el-menu-item index="2">Рефрижераторные перевозки</el-menu-item></router-link>
        <router-link to="/terminal_services"><el-menu-item index="2">Терминальные услуги</el-menu-item></router-link>
        <router-link to="/groupage_cargo"><el-menu-item index="2">Сборный груз</el-menu-item></router-link>
        <router-link to="/about"><el-menu-item index="2">О нашей компании</el-menu-item></router-link>
      </el-submenu>
      <el-submenu index="3">
        <template slot="title"><i class="el-icon-map-location"></i>Маршруты</template>
        <router-link to="/route"><el-menu-item index="3">Список</el-menu-item></router-link>
        <router-link to="/city"><el-menu-item index="4">Активные города</el-menu-item></router-link>
      </el-submenu>
      <router-link to="/feedback"><el-menu-item index="4"><i class="el-icon-postcard"></i>Обратная связь</el-menu-item></router-link>
      <router-link to="/profiler"><el-menu-item index="4"><i class="el-icon-s-promotion"></i>Профайлинг</el-menu-item></router-link>
      <router-link to="/log"><el-menu-item index="5"><i class="el-icon-lock"></i>Логи</el-menu-item></router-link>
    </el-menu>
  </el-aside>
</template>

<script>
import { Loading } from 'element-ui';
export default {
  name: "Aside",
  methods: {
    flush() {
      let loadingInstance = Loading.service();
      this.axios.get('/api/cache/flush').then(()=> {
        loadingInstance.close();
      }).catch(()=> {
        loadingInstance.close();
      });
    }
  }
}
</script>

<style lang="scss">
.el-aside {
  color: #333;
}
.el-menu-item {
  a {
    text-decoration: none;
    color: inherit;
  }
}
.el-submenu__title {
  background-color: #e4e9ef;
}
</style>