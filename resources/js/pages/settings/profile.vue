<template>
  <card :title="$t('your_info')">
    <form @submit.prevent="update" @keydown="form.onKeydown($event)">
      <alert-success :form="form" :message="$t('info_updated')" />
      <div class="row">
          <!-- Personal data -->
          <div class="col-12 col-md-6">
              <!-- firstName -->
              <div class="form-group">
                  <label class="form-label">{{ $t('firstname') }}</label>
                  <input v-model="form.firstname" :class="{ 'is-invalid': form.errors.has('firstname') }" class="form-control"
                      type="text" name="firstname">
                  <has-error :form="form" field="firstname" />
              </div>

              <!-- lastname -->
              <div class="form-group">
                  <label class="form-label">{{ $t('lastname') }}</label>
                  <input v-model="form.lastname" :class="{ 'is-invalid': form.errors.has('lastname') }" class="form-control"
                      type="text" name="lastname">
                  <has-error :form="form" field="lastname" />
              </div>

              <!-- Email -->
              <div class="form-group">
                  <label class="form-label">{{ $t('email') }}</label>
                  <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control"
                      type="email" name="email">
                  <has-error :form="form" field="email" />
              </div>

              <!-- phone -->
              <div class="form-group">
                  <label class="form-label">{{ $t('phone') }}</label>
                  <input v-model="form.phone" v-mask="'+48 ### ## ## ##'" :class="{ 'is-invalid': form.errors.has('phone') }"
                      class="form-control" type="tel" name="phone">
                  <has-error :form="form" field="phone" />
              </div>

          </div>
          <!-- Company data -->
          <div class="col-12 col-md-6">
              <!-- company -->
              <div class="form-group">
                  <label class="form-label">{{ $t('company') }}</label>
                  <input v-model="form.company" :class="{ 'is-invalid': form.errors.has('company') }" class="form-control"
                      type="text" name="company">
                  <has-error :form="form" field="company" />
              </div>
              <!-- vat_number -->
              <div class="form-group">
                  <label class="form-label">{{ $t('vat_number') }}</label>
                  <input v-model="form.vat_number" v-mask="'###-###-##-###'"
                      :class="{ 'is-invalid': form.errors.has('vat_number') }" class="form-control" type="text"
                      name="vat_number">
                  <has-error :form="form" field="vat_number" />
              </div>
              <!-- street -->
              <div class="form-group">
                  <label class="form-label">{{ $t('street') }}</label>
                  <input v-model="form.street" :class="{ 'is-invalid': form.errors.has('street') }" class="form-control"
                      type="text" name="street">
                  <has-error :form="form" field="street" />
              </div>

              <!-- city -->
              <div class="form-group">
                  <label class="form-label">{{ $t('city') }}</label>
                  <input v-model="form.city" :class="{ 'is-invalid': form.errors.has('city') }" class="form-control"
                      type="text" name="city">
                  <has-error :form="form" field="city" />
              </div>

              <!-- postcode -->
              <div class="form-group">
                  <label class="form-label">{{ $t('postcode') }}</label>
                  <input v-model="form.postcode" v-mask="'##-###'" :class="{ 'is-invalid': form.errors.has('postcode') }"
                      class="form-control" type="text" name="postcode">
                  <has-error :form="form" field="postcode" />
              </div>

          </div>
      </div>

      <!-- Submit Button -->
      <div class="form-footer d-flex justify-content-end">
        <v-button :loading="form.busy" type="success">
          {{ $t('update') }}
        </v-button>
      </div>
    </form>
  </card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: this.$t('settings') }
  },

  data: () => ({
    form: new Form({
      firstname: '',
      lastname: '',
      phone: '',
      company: '',
      vat_number: '',
      street: '',
      city: '',
      postcode: '',
      email: ''
    })
  }),

  computed: mapGetters({
    user: 'auth/user'
  }),

  created () {
    // Fill the form with user data.
    this.form.keys().forEach(key => {
      this.form[key] = this.user[key]
    })
  },

  methods: {
    async update () {
      const { data } = await this.form.patch('/api/settings/profile')

      this.$store.dispatch('auth/updateUser', { user: data })
    }
  }
}
</script>
