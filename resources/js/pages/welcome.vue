<template>
  <div>
    <!--    <div class="top-right links">-->
    <!--    <template v-if="authenticated">-->
    <!--      <router-link :to="{ name: 'home' }">-->
    <!--        {{ $t('home') }}-->
    <!--      </router-link>-->
    <!--    </template>-->
    <!--    <template v-else>-->
    <!--      <router-link :to="{ name: 'login' }">-->
    <!--        {{ $t('login') }}-->
    <!--      </router-link>-->
    <!--      <router-link :to="{ name: 'register' }">-->
    <!--        {{ $t('register') }}-->
    <!--      </router-link>-->
    <!--    </template>-->
    <!--  </div>-->
    <div class="container">
      <div class="row flex-nowrap">
        <div class="col-4 sh-border m-1 text-center">
          <div>Import CSV</div>
          <input id="file" type="file" class="input-field" @change="onChangeFile">
          <button type="submit" class="btn btn-primary my-2 w-100" @click="submit">
            Submit
          </button>
        </div>
        <div class="col-4 sh-border m-1 text-center">
          <div>Find by city</div>
          <input v-model="city" type="text" class="input-field" @input="findCity(city)">
        </div>
        <div class="col-4 sh-border m-1 text-center">
          <div>Find by ZIP</div>
          <input v-model="zipNumber" type="text" class="input-field" @emptied="getData">
          <button class="btn btn-primary" @click="findZip(zipNumber)">
            Search
          </button>
        </div>
      </div>
      <hr>
      <div v-if="mes">
        <div style="color: red; font-weight: bold">
          {{ mes }}
        </div>
      </div>
      <div v-if="data.length !== 0" class="row bg-white">
        <ul v-for="(item, index) in data" v-if="index < perPage" class="col-4 ">
          <li>ZIP: <span>{{ item.zip }}</span></li>
          <li>lat: <span>{{ item.lat }}</span></li>
          <li>lng: <span>{{ item.lng }}</span></li>
          <li>city: <span>{{ item.city }}</span></li>
          <li>state_id: <span>{{ item.state_id }}</span></li>
          <li>state_name: <span>{{ item.state_name }}</span></li>
          <li>zcta: <span>{{ item.zcta }}</span></li>
          <li>parent_zcta: <span>{{ item.parent_zcta }}</span></li>
          <li>population: <span>{{ item.population }}</span></li>
          <li>density: <span>{{ item.density }}</span></li>
          <li>country_fips: <span>{{ item.country_fips }}</span></li>
          <li>county_name: <span>{{ item.county_name }}</span></li>
          <li>county_weights: <span>{{ item.county_weights }}</span></li>
          <li>county_names_all: <span>{{ item.county_names_all }}</span></li>
          <li>county_fips_all: <span>{{ item.county_fips_all }}</span></li>
          <li>imprecise: <span>{{ item.imprecise }}</span></li>
          <li>military: <span>{{ item.military }}</span></li>
          <li>timezone: <span>{{ item.timezone }}</span></li>
          <hr>
        </ul>
      </div>
      <button class="btn btn-primary my-5" @click="loadMore">Load more</button>

    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import axios from 'axios'

export default {
  layout: 'basic',
  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName,
    file: '',
    data: {},
    zipNumber: '',
    city: '',
    mes: '',
    perPage: 10
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  }),
  mounted () {
    this.getData()
  },
  methods: {
    getData () {
      axios.get('/api/get-data')
        .then(response => {
          this.data = response.data
        })
    },
    onChangeFile (e) {
      this.file = e.target.files[0]
    },
    findZip (value) {
      axios.post('/api/find-zip', { zip: value })
        .then(response => {
          this.data = response.data
        })
    },
    findCity (value) {
      if (value.length >= 2 || value.length == 0) {
        axios.post('/api/find-city', { city: value })
          .then(response => {
            this.data = response.data
            if (this.data < 1) {
              this.mes = 'Не найдено'
            } else {
              this.mes = ''
            }
          })
      } else {
        this.mes = 'Введите два или более символов'
      }
    },
    submit () {
      const config = {
        headers: { 'content-type': 'multipart/form-data' }
      }
      let formData = new FormData()
      formData.append('file', this.file)
      axios.post('/api/import-data', formData, config)
        .then(response => {
          this.mes = response.data
        })
    },
    loadMore(){
      this.perPage += 10;
    }
  }
}
</script>

<style scoped>
  .top-right {
    position: absolute;
    right: 10px;
    top: 18px;
  }

  .title {
    font-size: 85px;
  }
  .bg-white{
    background: #fff;
  }
  .sh-border{
    padding: 10px;
    box-shadow: 0px 0px 2px 2px darkgrey;
  }
  .center{
    margin: 0 auto;
  }
</style>
