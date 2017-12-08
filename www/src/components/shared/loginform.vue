<template>
<b-dropdown position="is-bottom-left">
    <p class="control" slot="trigger">
            <a class="bd-tw-button button">
              <router-link to="/user" class="navbar-item">
              <span class="icon">
                <i class="fa fa-user"></i>
              </span>
              </router-link>
            </a>
          </p>

  <b-dropdown-item custom paddingless>
    <form action="">
      <div class="modal-card" style="width:300px;">
        <section class="modal-card-body">
            <b-field label="Email">
                <b-input
                    type="email"
                    placeholder="Your email"
                    required>
                </b-input>
            </b-field>

            <b-field label="Password">
                <b-input
                    type="password"
                    password-reveal
                    placeholder="Your password"
                    required>
                </b-input>
            </b-field>

            <b-checkbox>Remember me</b-checkbox>
        </section>
        <footer class="modal-card-foot">
            <button class="button is-primary">Login</button>
        </footer>
      </div>
    </form>
  </b-dropdown-item>
</b-dropdown>
</template>

<script>
export default {

}
</script>

<style>

</style>
