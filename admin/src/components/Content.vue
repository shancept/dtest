<template>
  <el-container>
    <el-header style="text-align: right; font-size: 12px">
      <el-dropdown>
        <i class="el-icon-setting" style="margin-right: 15px"></i>
        <el-dropdown-menu slot="dropdown">
          <el-dropdown-item onclick="document.location.href = '/logout'">Выйти</el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
      <span>{{user}}</span>
    </el-header>
    <router-view/>
  </el-container>
</template>

<script>
export default {
  name: "Content",
  computed: {
    user() {
      return this.$store.state.user
    }
  }
}
</script>

<style lang="scss">
.el-header {
  background-color: #B3C0D1;
  color: #333;
  line-height: 60px;

  span {
    font-size: 15px;
  }
}
</style>