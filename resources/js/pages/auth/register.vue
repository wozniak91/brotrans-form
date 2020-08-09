<template>
  <div class="row">
    <div class="col-lg-9 m-auto">
      <card v-if="mustVerifyEmail" :title="$t('register')">
        <div class="alert alert-success" role="alert">
          {{ $t('verify_email_address') }}
        </div>
      </card>
      <div v-else class="card">
        <h3 class="card-title">{{ $t('register') }}</h3>
        <form @submit.prevent="register" @keydown="form.onKeydown($event)">
          <div class="card-body">
            <div class="row">
              <!-- Personal data -->
              <div class="col-12 col-md-6">
                <!-- firstName -->
                <div class="form-group">
                  <label class="form-label">{{ $t('firstname') }}</label>
                  <input v-model="form.firstname" :class="{ 'is-invalid': form.errors.has('firstname') }" class="form-control" type="text" name="firstname">
                  <has-error :form="form" field="firstname" />
                </div>

                <!-- lastname -->
                <div class="form-group">
                  <label class="form-label">{{ $t('lastname') }}</label>
                  <input v-model="form.lastname" :class="{ 'is-invalid': form.errors.has('lastname') }" class="form-control" type="text" name="lastname">
                  <has-error :form="form" field="lastname" />
                </div>     

                <!-- Email -->
                <div class="form-group">
                  <label class="form-label">{{ $t('email') }}</label>
                  <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email">
                  <has-error :form="form" field="email" />
                </div>

                <!-- phone -->
                <div class="form-group">
                  <label class="form-label">{{ $t('phone') }}</label>
                  <input v-model="form.phone" v-mask="'+48 ### ## ## ##'" :class="{ 'is-invalid': form.errors.has('phone') }" class="form-control" type="tel" name="phone">
                  <has-error :form="form" field="phone" />
                </div> 

                <!-- Password -->
                <div class="form-group">
                  <label class="form-label">{{ $t('password') }}</label>
                  <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="form-control" type="password" name="password">
                  <has-error :form="form" field="password" />
                </div>

                <!-- Password Confirmation -->
                <div class="form-group">
                  <label class="form-label">{{ $t('confirm_password') }}</label>
                  <input v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }" class="form-control" type="password" name="password_confirmation">
                  <has-error :form="form" field="password_confirmation" />
                </div>
              </div>
              <!-- Company data -->
              <div class="col-12 col-md-6">
                <!-- company -->
                <div class="form-group">
                  <label class="form-label">{{ $t('company') }}</label>
                  <input v-model="form.company" :class="{ 'is-invalid': form.errors.has('company') }" class="form-control" type="text" name="company">
                  <has-error :form="form" field="company" />
                </div>
                <!-- vat_number -->
                <div class="form-group">
                  <label class="form-label">{{ $t('vat_number') }}</label>
                  <input v-model="form.vat_number" v-mask="'###-###-##-###'" :class="{ 'is-invalid': form.errors.has('vat_number') }" class="form-control" type="text" name="vat_number">
                  <has-error :form="form" field="vat_number" />
                </div>
                <!-- street -->
                <div class="form-group">
                  <label class="form-label">{{ $t('street') }}</label>
                  <input v-model="form.street" :class="{ 'is-invalid': form.errors.has('street') }" class="form-control" type="text" name="street">
                  <has-error :form="form" field="street" />
                </div>

                <!-- city -->
                <div class="form-group">
                  <label class="form-label">{{ $t('city') }}</label>
                  <input v-model="form.city" :class="{ 'is-invalid': form.errors.has('city') }" class="form-control" type="text" name="city">
                  <has-error :form="form" field="city" />
                </div>

                <!-- postcode -->
                <div class="form-group">
                  <label class="form-label">{{ $t('postcode') }}</label>
                  <input v-model="form.postcode" v-mask="'##-###'" :class="{ 'is-invalid': form.errors.has('postcode') }" class="form-control" type="text" name="postcode">
                  <has-error :form="form" field="postcode" />
                </div>

              </div>
            </div>

          </div>
          <v-button :block="true" :loading="form.busy">
            {{ $t('register') }}
          </v-button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {
  middleware: 'guest',
  layout: 'basic',
  metaInfo () {
    return { title: this.$t('register') }
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
      email: '',
      password: '',
      password_confirmation: ''
    }),
    mustVerifyEmail: false
  }),

  methods: {
    async register () {
      // Register the user.
      const { data } = await this.form.post('/api/register')

      // Must verify email fist.
      if (data.status) {
        this.mustVerifyEmail = true
      } else {
        // Log in the user.
        const { data: { token } } = await this.form.post('/api/login')

        // Save the token.
        this.$store.dispatch('auth/saveToken', { token })

        // Update the user.
        await this.$store.dispatch('auth/updateUser', { user: data })

        // Redirect home.
        this.$router.push({ name: 'order' })
      }
    }
  }
}
</script>
