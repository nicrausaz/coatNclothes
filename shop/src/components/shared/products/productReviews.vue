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
    <article class="media" id="newCommentZone">
      <div class="media-content">
        <div class="field">
          <p class="control">
            <span class="subtitle">Notez cet article</span>
            <star-rating :increment="0.5" :star-size="25" :show-rating="false" v-model="newComment.commentsAndOpinions_note" :inline="false"></star-rating>
          </p>
        </div>
        <div class="field" v-if="hasNoted">
          <p class="control">
            <textarea class="textarea" :placeholder="$store.state.interface.addComment" v-model="newComment.commentsAndOpinions_comment"></textarea>
          </p>
        </div>
        <button class="button is-pulled-right" @click="postComment" :disabled="!hasNoted">{{$store.state.interface.comment}}</button>
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
  computed: {
    hasNoted () {
      return this.newComment.commentsAndOpinions_note > 0
    }
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
        this.reset()
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

<style scoped>
#newCommentZone {
  border-top: 1px solid lightgray;
}
</style>

