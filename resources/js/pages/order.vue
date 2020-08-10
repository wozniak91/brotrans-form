<template>
  <card :title="$t('make_order')">
    <form @submit.prevent="submit" @keydown="form.onKeydown($event)">
      
      <div class="row">
        <div class="col-12 col-md-6">
          <h4 class="h5 pb-2 border-bottom">{{ $t('order_info') }}</h4>
          <!-- delivery_fullname -->
          <div class="form-group">
            <label class="form-label">{{ $t('delivery_fullname') }}</label>
            <input v-model="form.delivery_fullname" :class="{ 'is-invalid': form.errors.has('delivery_fullname') }" class="form-control" type="text" name="delivery_fullname" :placeholder="$t('delivery_fullname_placeholder')">
            <has-error :form="form" field="delivery_fullname" />
          </div>

          <!-- email -->
          <div class="form-group">
            <label class="form-label">{{ $t('email') }}</label>
            <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="form-control" type="email" name="email" :placeholder="$t('email_placeholder')">
            <has-error :form="form" field="email" />
          </div>

          <!-- delivery_company -->
          <div class="form-group">
            <label class="form-label">{{ $t('company') }}</label>
            <input v-model="form.delivery_company" :class="{ 'is-invalid': form.errors.has('delivery_company') }" class="form-control" type="text" name="delivery_company" :placeholder="$t('delivery_company_placeholder')">
            <has-error :form="form" field="delivery_company" />
          </div>

          <!-- delivery_address -->
          <div class="form-group">
            <label class="form-label">{{ $t('address') }}</label>
            <input v-model="form.delivery_address" :class="{ 'is-invalid': form.errors.has('delivery_address') }" class="form-control" type="text" name="delivery_address" :placeholder="$t('delivery_address_placeholder')">
            <has-error :form="form" field="delivery_address" />
          </div>

          <!-- delivery_city -->
          <div class="form-group">
            <label class="form-label">{{ $t('city') }}</label>
            <input v-model="form.delivery_city" :class="{ 'is-invalid': form.errors.has('delivery_city') }" class="form-control" type="text" name="delivery_city" :placeholder="$t('delivery_city_placeholder')">
            <has-error :form="form" field="delivery_city" />
          </div>

          <!-- delivery_postcode -->
          <div class="form-group">
            <label class="form-label">{{ $t('postcode') }}</label>
            <input v-model="form.delivery_postcode" v-mask="'##-###'" :class="{ 'is-invalid': form.errors.has('delivery_postcode') }" class="form-control" type="text" name="delivery_postcode" :placeholder="$t('delivery_postcode_placeholder')">
            <has-error :form="form" field="delivery_postcode" />
          </div>

          <!-- phone -->
          <div class="form-group">
            <label class="form-label">{{ $t('phone') }}</label>
            <input v-model="form.phone" :class="{ 'is-invalid': form.errors.has('phone') }" v-mask="'+48 ### ## ## ##'" class="form-control" type="tel" name="phone" :placeholder="$t('phone_placeholder')">
            <has-error :form="form" field="phone" />
          </div>

        </div>
        <div class="col-12 col-md-6">
          
          <!-- paid -->
          <div class="form-group">
            <label class="form-label">{{ $t('payment_status') }}</label>
            <select v-model="form.paid" :class="{ 'is-invalid': form.errors.has('paid') }" class="form-control" name="paid">
              <option value="1">{{ $t('paid') }}</option>
              <option value="0">{{ $t('cash_on_delivery') }}</option>
            </select>
            <has-error :form="form" field="paid" />
          </div> 

          <!-- delivery_price -->
          <div class="form-group">
            <label class="form-label">{{ $t('delivery_price') }}</label>
            <div class="input-group">
              <input v-model="form.delivery_price" :class="{ 'is-invalid': form.errors.has('delivery_price') }" min="0" class="form-control" type="number" name="delivery_price" >
              <div class="input-group-append">
                <span class="input-group-text">PLN</span>
              </div>
            </div>
            <has-error :form="form" field="delivery_price" />
          </div>

          <h4 class="h5 pb-2 border-bottom mb-0">{{ $t('products') }}</h4>
          <has-error :form="form" field="products" :class="{ 'd-block': form.errors.has('products') }" />
          <order-products :products.sync="form.products"  @addProduct="addProduct" @removeProduct="removeProduct" />
          
          <h4 class="h5 pb-2 border-bottom mt-4 mb-0">{{ $t('summary') }}</h4>
          <order-summary :products.sync="form.products" :delivery_price.sync="form.delivery_price" />
          <!-- Submit Button -->
          <div class="form-footer d-flex justify-content-end">
            <v-button :loading="form.busy" type="success">
              {{ $t('confirm_order') }}
            </v-button>
          </div>
        </div>
      </div>

    </form>
  </card>
</template>

<script>
import Form from 'vform';
import OrderProducts from './../components/Order/OrderProducts'
import OrderSummary from './../components/Order/OrderSummary'
import Swal from 'sweetalert2'

export default {
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('make_order') }
  },
  components: {
    OrderProducts,
    OrderSummary
  },
  data: () => ({
    form: new Form({
      user_comments: "",
      admin_comments: "",
      phone: "",
      email: "",
      payment_method: "",
      payment_method_cod: "",
      paid: "1",
      delivery_price: 0,
      delivery_fullname: "",
      delivery_company: "",
      delivery_address: "",
      delivery_city: "",
      delivery_postcode: "",
      products: [
      ]
    })
  }),
  methods: {
    submit() {

      this.form.post(`/api/order`)
        .then(resp => resp.data)
        .then(resp => {
          console.log(resp)
          this.form.reset();

          const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-link'
            },
            buttonsStyling: false
          })

          swalWithBootstrapButtons.fire({
            icon: 'success',
            title: this.$t('thanks_you'),
            text: this.$t('your_order_has_been_success'),
            showConfirmButton: true
          })

        })
    },
    addProduct(product) {
      this.form.products.push(product)
    },
    removeProduct(uuid) {
      // this.form.products.push(product)
      this.form.products = this.form.products.filter(product => product.uuid != uuid)
    }
  }
}
</script>
