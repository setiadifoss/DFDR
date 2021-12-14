<template>
<div class="jumbotron">
  <div class="container">

    <div class="row">
      <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="card">
          <div class="card-body p-4">
            <div>
              <nav class="navbar-light bg-light mb-2" 
                    style="padding-left:15px; padding-right:15px; padding-top:5px;">
                <div class="row">
                  <div class="col-md-12">
                    <a class="navbar-brand title-text" 
                        v-on:click.prevent="onMenuClick('cont_guide')"
                        style="cursor: pointer; width:100%;">
                      &nbsp; <i class="fa fa-address-book small"></i> &nbsp; Content Guideline
                    </a>
                  </div>
                </div>
              </nav>
            </div>
            <div>
              <nav class="navbar-light bg-light mb-2" 
                    style="padding-left:15px; padding-right:15px; padding-top:5px;">
                <div class="row">
                  <div class="col-md-12">
                    <a class="navbar-brand title-text" 
                        v-on:click.prevent="how_submit = !how_submit"
                        style="cursor: pointer; width:100%;">
                      &nbsp; <i class="fa fa-question-circle small"></i> &nbsp; How to Submit
                    </a>
                  </div>
                  <!-- <div class="col-md-12" v-if="v_option"> -->
                  <div class="col-md-12" v-if="how_submit">
                    <hr style="margin:8px; padding:0;">
                    <ul style="list-style-type: circle" class="mt-2">
                      <li>
                        <p
                          class="cat"
                          style="cursor: pointer"
                          v-on:click.prevent="onMenuClick('thes_diss')"
                        >
                          Thesis & Dissertation
                        </p>
                      </li>
                      <li>
                        <p
                          class="cat"
                          style="cursor: pointer"
                          v-on:click.prevent="onMenuClick('facu_work')"
                        >
                          Faculty & Staff Work
                        </p>
                      </li>
                      <li>
                        <p
                          class="cat"
                          style="cursor: pointer"
                          v-on:click.prevent="onMenuClick('grad_work')"
                        >
                          Graduate Work (Non-thesis)
                        </p>
                      </li>
                      <li>
                        <p
                          class="cat"
                          style="cursor: pointer"
                          v-on:click.prevent="onMenuClick('ungrad_work')"
                        >
                          Undergraduate Work
                        </p>
                      </li>
                    </ul>
                  </div>    
                </div>
              </nav>
            </div>
            <div>
              <nav class="navbar-light bg-light mb-2" 
                    style="padding-left:15px; padding-right:15px; padding-top:5px;">
                <div class="row">
                  <div class="col-md-12">
                    <a class="navbar-brand title-text" 
                        v-on:click.prevent="onMenuClick('license')"
                        style="cursor: pointer; width:100%;">
                      &nbsp; <i class="fa fa-star small"></i> &nbsp; License
                    </a>
                  </div>
                </div>
              </nav>
            </div>
            <div>
              <nav class="navbar-light bg-light mb-2" 
                    style="padding-left:15px; padding-right:15px; padding-top:5px;">
                <div class="row">
                  <div class="col-md-12">
                    <a class="navbar-brand title-text" 
                        v-on:click.prevent="onMenuClick('user_guide')"
                        style="cursor: pointer; width:100%;">
                      &nbsp; <i class="fa fa-user-circle small"></i> &nbsp; User Guides
                    </a>
                  </div>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-8 text-center mt-4" v-if="loading">
        <loading-component></loading-component>
      </div>
      <div class="col-md-8 col-sm-12 col-xs-12" v-if="!loading">
        <div class="card">
          <div class="card-body p-content" v-if="submission">
            <div>
              <h2>Submissions</h2>
              <hr><br>
              <p>&nbsp; &nbsp; &nbsp; Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s :</p>

              <div class="row mt-4 mb-5">
                <div class="col-md-3">
                  <ul class="list-group">
                    <li class="list-group-item text-center">
                      <p class="cat small"
                        style="cursor: pointer; font-size: 12 px;"
                        v-on:click.prevent="onMenuClick('thes_diss')">
                        Thesis & Dissertation
                      </p>
                    </li>
                  </ul>
                </div>
                <div class="col-md-3">
                  <ul class="list-group">
                    <li class="list-group-item text-center">
                      <p class="cat small"
                        style="cursor: pointer; font-size: 12 px;"
                        v-on:click.prevent="onMenuClick('facu_work')">
                        Faculty & Staff Work
                      </p>
                    </li>
                  </ul>
                </div>
                <div class="col-md-3">
                  <ul class="list-group">
                    <li class="list-group-item text-center">
                      <p class="cat small"
                        style="cursor: pointer; font-size: 12 px;"
                        v-on:click.prevent="onMenuClick('grad_work')">
                        Graduate Work (Non-thesis)
                      </p>
                    </li>
                  </ul>
                </div>
                <div class="col-md-3">
                  <ul class="list-group">
                    <li class="list-group-item text-center">
                      <p class="cat small"
                        style="cursor: pointer; font-size: 12 px;"
                        v-on:click.prevent="onMenuClick('ungrad_work')">
                        Undergraduate Work
                      </p>
                    </li>
                  </ul>
                </div>
              </div>
              
              <p>&nbsp; &nbsp; &nbsp; Contrary to popular belief, Lorem Ipsum is not simply random text. 
                It has roots in a piece of classical Latin literature from 45 BC, making 
                it over 2000 years old. Please see our 
                      <a class="cat"
                        style="cursor: pointer;"
                        v-on:click.prevent="onMenuClick('cont_guide')">Content Guideline</a>. 
                Richard McClintock, 
                a Latin professor at Hampden-Sydney College in Virginia, looked up one of 
                the more obscure Latin words, consectetur, from a Lorem Ipsum passage</p>

            </div>
          </div>
          <div class="card-body p-content" v-if="cont_guide">
            <div>
              <h2>Content Guideline</h2>
              <hr><br>
              <p>&nbsp; &nbsp; &nbsp; Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
                Contrary to popular belief, Lorem Ipsum is not simply random text. 
                It has roots in a piece of classical Latin literature from 45 BC, making 
                it over 2000 years old.</p>
              <br>
              <div>
                <nav class="navbar-light bg-light mb-2" 
                      style="padding-left:15px; padding-right:15px; padding-top:5px;">
                  <div class="row">
                    <div class="col-md-12">
                      <a class="navbar-brand title-text" 
                          v-on:click.prevent="cont_guide_1 = !cont_guide_1"
                          style="cursor: pointer; width:100%;">
                        &nbsp; <i class="fa fa-caret-down"></i>&nbsp; What is Lorem Ipsum
                      </a>
                    </div>
                    <div class="col-md-12" v-if="cont_guide_1">
                      <hr style="margin:8px; padding:0;">
                      <p class="m-3">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                        Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
                        when an unknown printer took a galley of type and scrambled it to make a type 
                        specimen book.</p>
                    </div>    
                  </div>
                </nav>
              </div>
              <div>
                <nav class="navbar-light bg-light mb-2" 
                      style="padding-left:15px; padding-right:15px; padding-top:5px;">
                  <div class="row">
                    <div class="col-md-12">
                      <a class="navbar-brand title-text" 
                          v-on:click.prevent="cont_guide_2 = !cont_guide_2"
                          style="cursor: pointer; width:100%;">
                        &nbsp; <i class="fa fa-caret-down"></i>&nbsp; Where does it come from
                      </a>
                    </div>
                    <div class="col-md-12" v-if="cont_guide_2">
                      <hr style="margin:8px; padding:0;">
                      <p class="m-3">
                        Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, 
                        looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum 
                        passage, and going through the cites of the word in classical literature, 
                        discovered the undoubtable source.</p>
                    </div>    
                  </div>
                </nav>
              </div>
              <div>
                <nav class="navbar-light bg-light mb-2" 
                      style="padding-left:15px; padding-right:15px; padding-top:5px;">
                  <div class="row">
                    <div class="col-md-12">
                      <a class="navbar-brand title-text" 
                          v-on:click.prevent="cont_guide_3 = !cont_guide_3"
                          style="cursor: pointer; width:100%;">
                        &nbsp; <i class="fa fa-caret-down"></i>&nbsp; Why do we use it
                      </a>
                    </div>
                    <div class="col-md-12" v-if="cont_guide_3">
                      <hr style="margin:8px; padding:0;">
                      <p class="m-3">
                        The point of using Lorem Ipsum is that it has a more-or-less normal 
                        distribution of letters, as opposed to using 'Content here, content here', 
                        making it look like readable English.</p>
                    </div>    
                  </div>
                </nav>
              </div>
            </div>
          </div>
          <div class="card-body p-content" v-if="thes_diss">
            <div>
              <h2>Thesis and Dissertation</h2>
              <hr><br>
              <ul class="list-group">
                <li class="list-group-item text-center">
                  <p style="font-size: 12px;">
                    &nbsp; &nbsp; &nbsp; Contrary to popular belief, Lorem Ipsum is not simply random text. 
                    It has roots in a piece of classical Latin literature from 45 BC, making 
                    it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College 
                    in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem 
                    Ipsum passage
                  </p>
                </li>
              </ul>
              <br>
              <h5><i>What is Lorem Ipsum?</i></h5>
              <p>&nbsp; &nbsp; &nbsp; Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has 
              been the industry's standard dummy text ever since the 1500s, when an unknown printer took 
              a galley of type and scrambled it to make a type specimen book.</p>

            </div>
          </div>
          <div class="card-body p-content" v-if="facu_work">
            <div>
              <h2>Faculty and Staff Work</h2>
              <hr><br>
              <p>&nbsp; &nbsp; &nbsp; Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has 
              been the industry's standard dummy text ever since the 1500s, when an unknown printer took 
              a galley of type and scrambled it to make a type specimen book.It has survived not only five 
              centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
              It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum 
              passages, and more recently with desktop publishing software like Aldus PageMaker including 
              versions of Lorem Ipsum.</p>

            </div>
          </div>
          <div class="card-body p-content" v-if="grad_work">
            <div>
              <h2>Graduate Work (Non-thesis)</h2>
              <hr><br>
              <p>&nbsp; &nbsp; &nbsp; Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has 
              been the industry's standard dummy text ever since the 1500s, when an unknown printer took 
              a galley of type and scrambled it to make a type specimen book.It has survived not only five 
              centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
              It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum 
              passages, and more recently with desktop publishing software like Aldus PageMaker including 
              versions of Lorem Ipsum.</p>

            </div>
          </div>
          <div class="card-body p-content" v-if="ungrad_work">
            <div>
              <h2>Undergraduate Work</h2>
              <hr><br>
              <p>&nbsp; &nbsp; &nbsp; Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has 
              been the industry's standard dummy text ever since the 1500s, when an unknown printer took 
              a galley of type and scrambled it to make a type specimen book.It has survived not only five 
              centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
              It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum 
              passages, and more recently with desktop publishing software like Aldus PageMaker including 
              versions of Lorem Ipsum.</p>

            </div>
          </div>
          <div class="card-body p-content" v-if="license">
            <div>
              <h2>License</h2>
              <hr><br>
              <p>&nbsp; &nbsp; &nbsp; Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s :</p>
              <br>
              <ul class="list-group">
                <li class="list-group-item">
                  <p style="font-size: 12px;">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has 
                    been the industry's standard dummy text ever since the 1500s, when an unknown printer took 
                    a galley of type and scrambled it to make a type specimen book.It has survived not only five 
                    centuries, but also the leap into electronic typesetting, remaining essentially unchanged. 
                    It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum 
                    passages, and more recently with desktop publishing software like Aldus PageMaker including 
                    versions of Lorem Ipsum.<br><br>
                    <ol>
                      <li>Lorem Ipsum is not simply random text</li>
                      <li>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</li>
                      <li>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</li>
                    </ol>
                  </p>
                </li>
              </ul>
              <br>
              <p>&nbsp; &nbsp; &nbsp; Contrary to popular belief, Lorem Ipsum is not simply random text. 
                It has roots in a piece of classical Latin literature from 45 BC, making 
                it over 2000 years old. Please see our <a href="">Content Guideline</a>. Richard McClintock, 
                a Latin professor at Hampden-Sydney College in Virginia, looked up one of 
                the more obscure Latin words, consectetur, from a Lorem Ipsum passage</p>

            </div>
          </div>
          <div class="card-body p-content" v-if="user_guide">
            <div>
              <h2>User Guides</h2>
              <hr><br>
              <p>&nbsp; &nbsp; &nbsp; Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s :</p><br>

              <ol>
                <li>Lorem Ipsum is not simply random text</li>
                <li>Lorem Ipsum has been the industry's standard dummy text since the 1500s.</li>
                <li>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested.</li>
              </ol>
              <br>
              <p>&nbsp; &nbsp; &nbsp; Contrary to popular belief, Lorem Ipsum is not simply random text. 
                It has roots in a piece of classical Latin literature from 45 BC, making 
                it over 2000 years old. Richard McClintock, 
                a Latin professor at Hampden-Sydney College in Virginia, looked up one of 
                the more obscure Latin words, consectetur, from a Lorem Ipsum passage</p>

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</template>

<style scoped>
.card {
  box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
  border-radius: .7rem !important;
}

.p-content {
  padding: 40px;
}

a {
  font-size: 17px;
}

.btn-primary {
  border-color: transparent;
}
@media only screen and (max-width: 600px) {
  .example {
    margin-top: 30px;
  }
}
</style>

<script>
export default {
  data() {
    return {
      loading: false,
      submission: true,
      cont_guide: false,
      how_submit: true,
      thes_diss: false,
      facu_work: false,
      grad_work: false,
      ungrad_work: false,
      license: false,
      user_guide: false,

      cont_guide_1: true,
      cont_guide_2: false,
      cont_guide_3: false,
    };
  },
  components: {},
  methods: {
    onMenuClick(mode) {
      this.loading = true;
      switch (mode) {
        case 'submission':
          this.submission = true
          this.cont_guide = false
          this.thes_diss = false
          this.facu_work = false
          this.grad_work = false
          this.ungrad_work = false
          this.license = false
          this.user_guide = false
          break;

        case 'cont_guide':
          this.submission = false
          this.cont_guide = true
          this.thes_diss = false
          this.facu_work = false
          this.grad_work = false
          this.ungrad_work = false
          this.license = false
          this.user_guide = false
          break;

        case 'thes_diss':
          this.submission = false
          this.cont_guide = false
          this.thes_diss = true
          this.facu_work = false
          this.grad_work = false
          this.ungrad_work = false
          this.license = false
          this.user_guide = false
          break;

        case 'facu_work':
          this.submission = false
          this.cont_guide = false
          this.thes_diss = false
          this.facu_work = true
          this.grad_work = false
          this.ungrad_work = false
          this.license = false
          this.user_guide = false
          break;
        
        case 'grad_work':
          this.submission = false
          this.cont_guide = false
          this.thes_diss = false
          this.facu_work = false
          this.grad_work = true
          this.ungrad_work = false
          this.license = false
          this.user_guide = false
          break;

        case 'ungrad_work':
          this.submission = false
          this.cont_guide = false
          this.thes_diss = false
          this.facu_work = false
          this.grad_work = false
          this.ungrad_work = true
          this.license = false
          this.user_guide = false
          break;

        case 'license':
          this.submission = false
          this.cont_guide = false
          this.thes_diss = false
          this.facu_work = false
          this.grad_work = false
          this.ungrad_work = false
          this.license = true
          this.user_guide = false
          break;

        case 'user_guide':
          this.submission = false
          this.cont_guide = false
          this.thes_diss = false
          this.facu_work = false
          this.grad_work = false
          this.ungrad_work = false
          this.license = false
          this.user_guide = true
          break;
      }
      setTimeout(() => this.loading = false, 300);
    },
  },
};
</script>
