
@props(['rating_questions' , 'product'])
<x-app
:title="'Rating Form'" 
:show_bread_crump="true"
:breadcumptitle="'Rating Form'"
:breadcumpdescription="'Create Your Own Rating'"
>	
<link rel="stylesheet" href="{{asset('assets/css/rating/review-form.css')}}">
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="contact-form">
                <h2 class="form-title">Rate Your Experience<br><span style="color:rgb(242, 129, 35);">{{$product->name}}</span></h2>
                
                <form method="POST" action="{{route('rating_reviews.store-rating')}}">
                    @csrf
                    
                    <input type='hidden' name ="product_id" value ="{{$product->id}}">
                    @foreach($rating_questions as $index => $rating_question)
                        <!-- Rating Section for each question -->
                        <div class="rating-section">
                            <div class="rating-title">{{$rating_question->details}}</div>
                            <input type="hidden" name="question_ids[]" value="{{ $rating_question->id }}">
                            <div class="rating-options">
                                <label class="rating-option">
                                    <input type="radio" name="rating_{{ $rating_question->id }}" value="1">
                                    <span class="emoji">😞</span>
                                    <span class="rating-label">Very Bad</span>
                                </label>
                                <label class="rating-option">
                                    <input type="radio" name="rating_{{ $rating_question->id }}" value="2">
                                    <span class="emoji">😐</span>
                                    <span class="rating-label">Bad</span>
                                </label>
                                <label class="rating-option">
                                    <input type="radio" name="rating_{{ $rating_question->id }}" value="3">
                                    <span class="emoji">🙂</span>
                                    <span class="rating-label">Good</span>
                                </label>
                                <label class="rating-option">
                                    <input type="radio" name="rating_{{ $rating_question->id }}" value="4">
                                    <span class="emoji">😊</span>
                                    <span class="rating-label">Very Good</span>
                                </label>
                                <label class="rating-option">
                                    <input type="radio" name="rating_{{ $rating_question->id }}" value="5">
                                    <span class="emoji">😍</span>
                                    <span class="rating-label">Excellent</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- Review Section -->
                    <div class="review-section">
                        <div class="review-label">Write your bros:</div>
                        <textarea name="review_bros" id="review" required placeholder="Please share your detailed feedback and experience with us..."></textarea>
                        <div class="review-label">Write your cons:</div>
                        <textarea name="review_cons" id="review"  required placeholder="Please share your detailed feedback and experience with us..."></textarea>
                    </div>
                    
                    <input type="submit" value="Submit Review" class="submit-btn">
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/rating-questions-emojis.js')}}"></script>

   

</x-app>