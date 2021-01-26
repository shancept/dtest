<template>
  <el-main>
    <h1>{{ this.$route.meta.title }}</h1>
    <el-button @click="clear" type="success">Очистить</el-button>
    <el-table
        :data="data.list"
        stripe
        lazy
        empty-text="пусто"
        style="width: 100%">
      <el-table-column v-for="(value, key) in data.attributeLabels" :key="key"
                       :prop="key"
                       :label="value">
      </el-table-column>
    </el-table>
  </el-main>
</template>

<script>
import {getToken, v} from '@/helpers/helper';

export default {
  name: "Log",
  data() {
    return {
      updated: false
    }
  },
  computed: {
    name() {
      return this.$route.name
    },
    data() {
      return v(this.$store.state, this.name, {list: [], attributeLabels: {}});
    }
  },
  mounted() {
    this.$store.dispatch('getData', this.name);
  },
  beforeUpdate() {
    if (!this.data.list.length && !this.updated) {
      this.$store.dispatch('getData', this.name);
      this.updated = true;
    }
  },
  methods: {
    clear() {
      let url = '/api/'+this.name;
      this.axios.delete(url, {data: {'access-token': getToken()}}).then(() => {
        this.$notify({
          title: 'Успех',
          message: 'Очищено',
          type: 'success'
        });
        this.$store.dispatch('getData', this.name);
      }).catch(error => {
        let m;
        try {
          m = error.response.data.result.message;
        } catch {
          m = 'Обратитесь к программисту';
        }
        this.$notify({
          title: 'Ошибка',
          message: m,
          type: 'error'
        });
      });
    }
  }
}
</script>

<style scoped>

</style>