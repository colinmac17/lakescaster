import React, {Component, Fragment} from 'react';
import StarRatingComponent from 'react-star-rating-component';
import axios from 'axios';

class ReviewModal extends Component {
    constructor(props){
        super(props)
        this.state = {
            rating: 0,
            review: ""
        }

        this.onStarClick = this.onStarClick.bind(this)
        this.handleReviewSubmit = this.handleReviewSubmit.bind(this)
        this.handleChange = this.handleChange.bind(this)
    }

    onStarClick(nextValue, prevValue, name){
        this.setState({rating: nextValue})
    }

    handleChange(e) {
        let change = {}
        change[e.target.name] = e.target.value
        this.setState(change)
    }

    handleReviewSubmit(e){
        e.preventDefault()
        const {rating, review} = this.state
        axios.post(`/${this.props.path}/review`, {rating: rating, review: review})
            .then((response) => {

            }).catch((err) => console.log(err))
    }

    render(){
        const {rating} = this.state
        return(
            <Fragment>
                <div className="modal" id="reviewModal" tabIndex="-1" role="dialog" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered" role="document">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title">Review for <span className="text-primary">{this.props.spotname}</span></h5>
                                <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div className="modal-body">
                                <form onSubmit={this.handleReviewSubmit} method="POST" action={"/" + this.props.path + "/review"}>
                                    <div className="form-group">
                                        <label htmlFor="review" className="col-form-label">Rating:</label><br/>
                                        <StarRatingComponent
                                            name="review"
                                            starCount={5}
                                            value={rating}
                                            onStarClick={this.onStarClick}
                                        />
                                    </div>
                                    <div className="form-group">
                                        {/*<label htmlFor="message-text" className="col-form-label">Comment:</label>*/}
                                        <textarea onChange={this.handleChange} name="review" placeholder="leave a review" className="form-control" id="message-text"></textarea>
                                    </div>
                                    <div className="modal-footer">
                                        <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" className="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </Fragment>
        )
    }
}

export {ReviewModal};