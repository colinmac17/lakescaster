import React, {Component, Fragment} from 'react';
import StarRatingComponent from 'react-star-rating-component';
import axios from 'axios';
import {MyContext} from '../Provider';
import $ from 'jquery';

class ReviewModal extends Component {
    constructor(props){
        super(props)
        this.state = {
            rating: 0,
            review: "",
            showStatus: false,
            statusType: 'success',
            action: props.action,
            myRating: '',
            myReview: '',
            reviewId: props.reviewId
        }

        this.onStarClick = this.onStarClick.bind(this)
        this.handleReviewSubmit = this.handleReviewSubmit.bind(this)
        this.handleChange = this.handleChange.bind(this)
        this.handleClose = this.handleClose.bind(this)
        this.updateId = this.updateId.bind(this)
    }

    onStarClick(nextValue, prevValue, name){
        if(this.props.action == 'post') {
            this.setState({rating: nextValue})
        } else if (this.props.action == 'edit'){
            this.setState({myRating: nextValue})
        }
    }

    handleChange(e) {
        let change = {}
        if(this.props.action == 'post') {
            change['review'] = e.target.value
        } else if(this.props.action == 'edit'){
            change['myReview'] = e.target.value
        }
        this.setState(change)
    }

    handleReviewSubmit(e, myReviewId, myRating2,myReview2){
        e.preventDefault()
        let review2 = this.state.myReview != '' ? this.state.myReview : myReview2
        let rating2 = this.state.myRating != '' ? this.state.myRating : myRating2
        const {rating, review, action} = this.state
        const data = (this.props.action == 'post') ? {rating: rating, review: review, action: action} : {rating: rating2, review: review2, action: action, reviewId: myReviewId}
        axios.post(`/${this.props.path}/review`, data)
            .then((response) => {
                $('button[data-dismiss="modal"]').click()
                if(response.status === 200){
                    this.setState({showStatus: true, statusType: 'success'})
                    $('#statusModal').show()
                } else {
                    this.setState({showStatus: true, statusType: 'failure'})
                }
            })
                .catch((err) => {
                    this.setState({showStatus: true, statusType: 'failure'})
                 })
    }

    handleClose(){
        this.setState({showStatus: false})
        location.reload(true)
    }

    updateId(myReviewId){
        this.setState({reviewId: myReviewId})
    }

    render(){
        const {rating} = this.state
        return(
            <MyContext.Consumer>
                {(context) => (
            <Fragment>
                <div className="modal" id={(this.props.action === 'post') ? 'reviewModal' : ((this.props.action === 'edit') ? 'editReviewModal' : 'deleteReviewModal')} tabIndex="-1" role="dialog" aria-hidden="true">
                    <div className="modal-dialog modal-dialog-centered" role="document">
                        <div className="modal-content">
                            <div className="modal-header">
                                {this.props.action == 'post' ?
                                    <h5 className="modal-title">Review for <span
                                        className="text-primary">{this.props.spotname}</span></h5>
                                    : (this.props.action == 'edit') ?
                                        <h5 className="modal-title">Edit Review for <span
                                            className="text-primary">{this.props.spotname}</span></h5> :
                                        <h5 className="modal-title">Delete Review for <span
                                            className="text-primary">{this.props.spotname}</span></h5>
                                }
                                <button type="button" className="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div className="modal-body">
                                {this.props.action == 'post'
                                    ?
                                    //Post Form
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
                                        <textarea onChange={this.handleChange} name="review" placeholder="leave a review" className="form-control" id="message-text"></textarea>
                                    </div>
                                    <div className="modal-footer">
                                        <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" className="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                                    : (this.props.action == 'edit') ?
                                        //Edit Form
                                        <form onSubmit={(event) => {this.handleReviewSubmit(event,context.state.myReviewId, this.state.myRating != '' ? this.state.myRating : parseInt(context.state.myRating), this.state.myReview != '' ? this.state.myReview : context.state.myReview)}} method="POST" action={"/" + this.props.path + "/review"}>
                                            <input type="hidden" name="reviewId" value={context.state.myReviewId} />
                                            <div className="form-group">
                                                <label htmlFor="review" className="col-form-label">Rating:</label><br/>
                                                <StarRatingComponent
                                                    name="review"
                                                    starCount={5}
                                                    value={this.state.myRating != '' ? this.state.myRating : parseInt(context.state.myRating)}
                                                    onStarClick={this.onStarClick}
                                                />
                                            </div>
                                            <div className="form-group">
                                                {/*<label htmlFor="message-text" className="col-form-label">Comment:</label>*/}
                                                <textarea onChange={this.handleChange} name={this.state.myReview != '' ? 'myReview' : 'review'} placeholder="leave a review" className="form-control" id="message-text" value={this.state.myReview != '' ? this.state.myReview : context.state.myReview}></textarea>
                                            </div>
                                            <div className="modal-footer">
                                                <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" className="btn btn-primary">Submit</button>
                                            </div>
                                        </form> :
                                        //Delete Form
                                        <form onSubmit={(event) => {this.handleReviewSubmit(event,context.state.myReviewId, this.state.myRating != '' ? this.state.myRating : parseInt(context.state.myRating), this.state.myReview != '' ? this.state.myReview : context.state.myReview)}} method="POST" action={"/" + this.props.path + "/review"}>
                                            <p>Are your sure you want to delete your review?</p>
                                            <div className="modal-footer">
                                                <button type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" className="btn btn-danger">Yes, Delete Now</button>
                                            </div>
                                        </form>
                                    }
                            </div>
                        </div>
                    </div>
                </div>
                {this.state.showStatus
                    ?
                <div className="status-modal">
                    <div id="statusModal" className="modal" tabIndex="-1" role="dialog" aria-labelledby="statusModal">
                        <div className="modal-dialog modal-dialog-centered" role="document">
                            <div className="modal-content">
                                <div className="modal-header">
                                    <h5 className={this.state.statusType === 'success' ? 'modal-title text-success' : 'modal-title text-danger'}>{this.state.statusType}</h5>
                                    <button type="button" onClick={this.handleClose} className="close" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div className="modal-body">
                                    {this.state.statusType === 'success'
                                    ?
                                        (this.props.action) == 'post' ?
                                        <p>Thank you, your review has been successfully saved!.</p>
                                            : (this.props.action == 'edit') ?
                                            <p>Thank you, your review has been successfully updated!.</p>
                                            : <p>Thank you, your review has been successfully removed!</p>
                                        :
                                        <p>Sorry, we had an error processing your review. Please refresh the page and try again and if still not working contact the developer at colin@colinmcatee.com</p>
                                    }
                                </div>
                                <div className="modal-footer">
                                    <button onClick={this.handleClose} type="button" className="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    : ""
                }
            </Fragment>
                )}
            </MyContext.Consumer>
        )
    }
}

export {ReviewModal};