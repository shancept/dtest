<template>
  <el-main>
    <h1>{{ title }}</h1>
    <el-button @click="send" :loading="loading" v-if="changed" type="primary">Сохранить</el-button>
    <set
        v-for="(set, key) in sets"
        :key="key"
        v-if="set.length"
        color="#e6e7ea"
        @changed="changed = true"
        :title="key"
        :data="set"
        :type="type"
    />
  </el-main>
</template>

<script>
import {getToken} from '@/helpers/helper'
import set from '@/components/Set'

export default {
  name: "Sets",
  props: ['sets','title', 'type'],
  components: {set},
  data() {
    return {
      changed: false,
      loading: false
    }
  },
  computed: {
    dataJson() {
      let data = [];
      for(let k in this.sets) {
        data = [...data, ...this.sets[k]]
      }
      return  JSON.stringify(data);
    }
  },
  methods: {
    send() {
      this.loading = true;
      let fd = new FormData();
      fd.append('access-token', getToken());
      fd.append('data', this.dataJson);

      this.axios.post('/api/sets/', fd)
          .then(response => {
            if (response.data.code === 200 && response.data.result.result === 'success') {
              this.changed = false;
              this.$notify({
                title: 'Успех',
                message: 'Сохранено успешно',
                type: 'success'
              });
            } else {
              this.$notify.error({
                title: 'Ошибка',
                message: 'Ошибка сохранения'
              });
            }
            this.loading = false;
          });
    }
  }
}
</script>