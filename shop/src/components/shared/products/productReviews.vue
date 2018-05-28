<template>
  <div>
    <article class="media" v-for="comment in comments" :key="comment.commentsAndOpinions_id">
      <div class="media-content">
        <div class="content">
          <p>
            <strong>{{comment.users_login}}</strong>
            <br>
            {{comment.commentsAndOpinions_comment}}
            <star-rating :star-size="20" :show-rating="false" :read-only="true" v-model="comment.commentsAndOpinions_note"></star-rating>
          </p>
        </div>
      </div>
    </article>
    <article class="media">
      <div class="media-content">
        <div class="field">
          <p class="control">
            <textarea class="textarea" :placeholder="$store.state.interface.addComment" v-model="newComment.commentsAndOpinions_comment"></textarea>
          </p>
        </div>
        <div class="field" style="padding: 10px;">
          <star-rating :increment="0.5" :star-size="25" :show-rating="false" v-model="newComment.commentsAndOpinions_note" :inline="true"></star-rating>
          <button class="button is-pulled-right" @click="postComment">{{$store.state.interface.comment}}</button>
        </div>
      </div>
    </article>
  </div>
</template>

<script>
import StarRating from 'vue-star-rating'

export default {
  data () {
    return {
      comments: [],
      newComment: {
        commentsAndOpinions_note: 0,
        commentsAndOpinions_comment: null
      }
    }
  },
  watch: {
    $route () {
      this.getComments()
    }
  },
  created () {
    this.getComments()
  },
  methods: {
    getComments () {
      this.axios({
        method: 'get',
        url: '/product/' + this.$route.params.id + '/comments'
      })
      .then(response => {
        this.comments = response.data
        this.comments.forEach(comment => {
          comment.commentsAndOpinions_note /= 2
        })
      })
    },
    postComment () {
      this.axios({
        method: 'put',
        url: '/user/' + this.$store.state.user.users_id + '/product/' + this.$route.params.id,
        data: {
          commentsAndOpinions_note: this.newComment.commentsAndOpinions_note * 2,
          commentsAndOpinions_comment: this.newComment.commentsAndOpinions_comment
        }
      })
      .then(response => {
        this.$toast.open(response.data)
      })
      .catch(err => {
        this.$toast.open(err.response.data)
      })
    },
    reset () {
      this.newComment.commentsAndOpinions_note = 0
      this.newComment.commentsAndOpinions_comment = null
      this.$emit('new')
      this.getComments()
    }
  },
  components: {
    StarRating
  }
}
</script>
