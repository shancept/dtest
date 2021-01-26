<template>
  <el-main>
    <h1>Маршруты</h1>
    <el-button @click="formVisible = true;" type="success">Добавить</el-button>
    <el-button @click="send" :loading="loading" v-if="changed" type="primary">Сохранить изменения</el-button>
    <my-route-form/>
    <el-table
        :data="route.list"
        stripe
        empty-text="пусто"
        style="width: 100%">
      <el-table-column
          prop="fromR.city"
          :label="route.attributeLabels['fromR']">
      </el-table-column>
      <el-table-column
          prop="toR.city"
          :label="route.attributeLabels['toR']">
      </el-table-column>
      <el-table-column
          prop="refrigerator"
          :formatter="refrigeratorFormatter"
          :label="route.attributeLabels['refrigerator']">
      </el-table-column>

      <el-table-column
          v-for="(column, key) in columns"
          :key="key"
          prop="column"
          :label="route.attributeLabels[column]">
        <template slot-scope="scope">
          <el-input placeholder="Введите" width="3px" @input="changeItem(scope.$index, column, $event)"
                    :value="scope.row[column]"></el-input>
        </template>
      </el-table-column>

      <el-table-column
          label="Действия">
        <template slot-scope="scope">
          <el-button
              size="mini"
              type="danger"
              @click="handleDelete(scope.row)">Удалить
          </el-button>
        </template>
      </el-table-column>
    </el-table>
  </el-main>
</template>

<script>
import {getToken} from "@/helpers/helper";
import MyRouteForm from "@/components/MyRouteForm";

export default {
  name: "Route",
  data() {
    return {
      changed: false,
      loading: false
    }
  },
  components: {MyRouteForm},
  computed: {
    route() {
      return this.$store.state.route;
    },
    formVisible: {
      get() {
        return this.$store.state.formVisible;
      },
      set(val) {
        this.$store.commit('set', {type: 'formVisible', data: val})
      }
    },
    formUpdate: {
      get() {
        return this.$store.state.formUpdate;
      },
      set(val) {
        this.$store.commit('set', {type: 'formUpdate', data: val})
      }
    },
    columns() {
      let keys = Object.keys(this.route.attributeLabels);
      return keys.filter(x => !['from', 'fromR', 'to', 'toR', 'refrigerator', 'url'].includes(x));
    },
  },
  methods: {
    handleDelete(row) {
      let url = '/api/route/item';
      this.axios.delete(url, {
        data: {
          'access-token': getToken(),
          from: row.from,
          to: row.to,
          ref: row.refrigerator,
        }
      }).then(response => {
        if (response.data.code === 200 && response.data.result.result === 'success') {
          this.$store.dispatch('getData', 'route');
          this.$notify({
            title: 'Успех',
            message: 'Удалено',
            type: 'success'
          });
        } else {
          this.$notify.error({
            title: 'Ошибка',
            message: 'Не удалено'
          });
        }
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
    },
    refrigeratorFormatter(row, column) {
      return row.refrigerator === '1' ? 'да' : 'нет'
    },
    changeItem(index, key, value) {
      this.$store.commit('updateRoute', {index: index, key: key, value: value});
      this.changed = true
    },
    send() {
      this.loading = true;
      let USP = new URLSearchParams();
      USP.append('access-token', getToken());
      USP.append('data', this.route.list);

      this.axios.put('/api/route/save', this.route.list, {params: {'access-token': getToken()}}).then(response => {
        this.$notify({
          title: 'Успех',
          message: 'Сохранено',
          type: 'success'
        });
        this.changed = this.loading = false;
      }).catch(() => {
        this.$notify.error({
          title: 'Ошибка',
          message: 'Не сохранено'
        });
        this.loading = false;
      });
    }
  }
}
</script>

<style scoped>

</style>