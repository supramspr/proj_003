<template>
  <v-sheet class="bg-deep-purple pa-12" rounded>
    <v-card class="mx-auto px-6 py-8 card card-container" max-width="344">
      <v-img
        id="profile-img"
        src="//ssl.gstatic.com/accounts/ui/avatar_2x.png"
        class="profile-img-card"
      />
      <v-form v-model="form" @submit.prevent="onSubmit">
        <v-text-field
          v-model="email"
          :readonly="loading"
          :rules="[required]"
          class="mb-2"
          type="email"
          clearable
          label="Email"
        ></v-text-field>

        <v-text-field
          v-model="password"
          :readonly="loading"
          :rules="[required]"
          type="password"
          clearable
          label="Password"
          placeholder="Enter your password"
        ></v-text-field>

        <br />

        <v-btn
          :disabled="!form"
          :loading="loading"
          block
          color="success"
          size="large"
          type="submit"
          variant="elevated"
        >
          Sign In
        </v-btn>
      </v-form>
    </v-card>
  </v-sheet>
</template>

<!-- 
<template>
    <v-sheet width="300" class="mx-auto">
  
      <v-form ref="form">
        <v-text-field
          v-model="email"
          :counter="10"
          :rules="email"
          type="email"
          label="email"
          required
        ></v-text-field>

        <v-text-field
          v-model="password"
          :counter="10"
          :rules="password"
          type="password"
          label="password"
          required
        ></v-text-field>
  
        <v-select
          v-model="select"
          :items="items"
          :rules="[v => !!v || 'Item is required']"
          label="Item"
          required
        ></v-select>
  
        <v-checkbox
          v-model="checkbox"
          :rules="[v => !!v || 'You must agree to continue!']"
          label="Do you agree?"
          required
        ></v-checkbox>
  
        <div class="d-flex flex-column">
          <v-btn
            color="success"
            class="mt-4"
            block
            @click="validate"
          >
            Validate
          </v-btn>
  
          <v-btn
            color="error"
            class="mt-4"
            block
            @click="reset"
          >
            Reset Form
          </v-btn>
  
          <v-btn
            color="warning"
            class="mt-4"
            block
            @click="resetValidation"
          >
            Reset Validation
          </v-btn>
        </div>
      </v-form>
    </v-sheet>
  </template> -->

<script>
import axios from "axios";
export default {
  data: () => ({
    form: false,
    email: null,
    password: null,
    loading: false,

    // valid: true,
    // name: "",
    // nameRules: [
    //   (v) => !!v || "Name is required",
    //   (v) => (v && v.length <= 10) || "Name must be less than 10 characters",
    // ],
    // select: null,
    // items: ["Item 1", "Item 2", "Item 3", "Item 4"],
    // checkbox: false,
  }),

  methods: {
    onSubmit() {
      if (!this.form) return;
      this.loading = true;
      try {
        axios
          .post("/auth/login", {
            email: this.email,
            password: this.password,
          })
          .then((result) => {
            this.isLoading = false;
            // this.$store.dispatch("simpanUser", result.data);
            this.$cookie.set("token", result.data.token, 1);
            this.addTokenToHeader(result.data.token);
            window.location.href = "/home";
          })
          .catch((err) => {
            (this.errorMessage = err.response.data.message ?? err),
              (this.isLoading = false);
          });
      } catch (error) {
        this.isLoading = false;
      }

      setTimeout(() => (this.loading = false), 2000);
    },
    // required(v) {
    //   return !!v || "Field is required";
    // },

    // async validate() {
    //   const { valid } = await this.$refs.form.validate();

    //   if (valid) alert("Form is valid");
    // },
    // reset() {
    //   this.$refs.form.reset();
    // },
    // resetValidation() {
    //   this.$refs.form.resetValidation();
    // },
  },
};
</script>