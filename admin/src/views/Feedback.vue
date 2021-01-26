<template>
  <el-main>
    <h1>Обратная связь</h1>
    <el-table
        :data="data.list"
        stripe
        lazy
        empty-text="пусто"
        style="width: 100%">
      <el-table-column v-for="(value, key) in attributeLabels" :key="key"
                       :prop="key"
                       :label="value"
                       width="250">
      </el-table-column>
      <el-table-column
          label="Operations">
        <template slot-scope="scope">
          <el-button
              size="mini"
              @click="view(scope.row)">Просмотр</el-button>
          <el-button
              size="mini"
              type="success"
              v-if="scope.row.status == 1"
              @click="process(scope.row.id)">Отметить как прочитанное</el-button>
        </template>
      </el-table-column>
    </el-table>
  </el-main>
</template>

<script>
import {getToken, objLength, v} from '@/helpers/helper'
import {Loading} from "element-ui";

export default {
  name: "Feedback",
  data() {
    return {
      name: 'feedback',
      item: {},
      attributeLabels_: {}
    }
  },
  computed: {
    data() {
      return v(this.$store.state, this.name, {list: [], attributeLabels: {}});
    },
    attributeLabels() {
      if (!objLength(this.attributeLabels_)) {
        for (let key in this.data.attributeLabels) {
          if (~['name', 'phone', 'date'].indexOf(key)) {
            this.attributeLabels_[key] = this.data.attributeLabels[key];
          }
        }
      }
      return this.attributeLabels_;
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
  created() {
    this.$store.dispatch('getData', this.name);
  },
  methods: {
    type(type) {
      if(type == 1) {
        return 'Обратная свзяь с калькулятора'
      }
      if(type == 2) {
        return 'Обратная свзяь с просьбой перезвонить'
      }
      return 'Обратная свзяь'
    },
    view(data) {
      const h = this.$createElement;
      this.$msgbox({
        title: this.type(data.type),
        message: h('div', null, [
          h('h3', null, this.data.attributeLabels['date']+': '+data.date),
          h('h3', null, this.data.attributeLabels['name']+': '+data.name),
          h('h3', null, this.data.attributeLabels['phone']+': '+data.phone),
          h('h3', null, this.data.attributeLabels['email']+': '+data.email),
          h('h3', null, this.data.attributeLabels['message']+': '+data.message),
          h('h3', null, this.data.attributeLabels['page']+': '+data.page),
          h('br', null),
          data.from ? h('h3', null, this.data.attributeLabels['from']+': '+data.from) : '',
          data.to ? h('h3', null, this.data.attributeLabels['to']+': '+data.to) : '',
          data.refrigerator ? h('h3', null, this.data.attributeLabels['refrigerator']+': '+data.refrigerator) : '',
          data.weight ? h('h3', null, this.data.attributeLabels['weight']+': '+data.weight) : '',
          data.volume ? h('h3', null, this.data.attributeLabels['volume']+': '+data.volume) : '',
          data.oversized_cargo ? h('h3', null, this.data.attributeLabels['oversized_cargo']+': '+data.oversized_cargo) : '',

        ]),
        showCancelButton: true,
        confirmButtonText: 'Отметить как прочитанное',
        cancelButtonText: 'Отмена',
        beforeClose: (action, instance, done) => {
          if (action === 'confirm') {
            instance.confirmButtonLoading = true;
            instance.confirmButtonText = 'Loading...';
            this.process(data.id);
            instance.confirmButtonLoading = false;
            done();
          } else {
            done();
          }
        }
      }).then(action => {
        if (action === 'confirm') {
          this.$message({
            type: 'info',
            message: 'Сообщение помечено как прочитанное'
          });
        }
      });
    },
    process(id) {
      let loadingInstance = Loading.service({fullscreen: true});
      let USP = new URLSearchParams();
      USP.append('access-token', getToken());
      USP.append('update-status', '1');

      this.axios.put('/api/feedback/' + id, USP).then(res => {
        if(res.data.result.result === 'success') {
          this.$notify({
            type: 'success',
            title: 'Обработано',
            message: 'Сообщение помечено как прочитанное'
          });
          this.$store.dispatch('getData', this.name);
        }
        loadingInstance.close();
      }).catch(() => {
        loadingInstance.close();
      })
    }
  }
}
</script>