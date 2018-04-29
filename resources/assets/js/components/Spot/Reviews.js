import React, {Component, Fragment} from 'react';
import {MyContext} from '../Provider';
import { ReviewModal } from '../Nuggets/ReviewModal';
import StarRatingComponent from 'react-star-rating-component';

class Reviews extends Component{
    constructor(props) {
        super(props)
        this.state = {
            data: {},
            action: ''
        }

        this.openReviewModal = this.openReviewModal.bind(this)
    }

    openReviewModal(e){
        e.preventDefault()
        let target = e.target.dataset.target
        switch(target){
            case '#editReviewModal':
                this.setState({action: 'edit'})
                break;
            case '#deleteReviewModal':
                this.setState({action: 'delete'})
                break;
            default:
                this.setState({action: 'post'})
                break;
        }
    }

    render(){
        return(
            <MyContext.Consumer>
                {(context) => (
                    <Fragment>
                        <h1>Reviews for {context.state.name}</h1>
                        <div className="review-setup">
                            {(context.auth == 1)
                                ? <Fragment>
                                    {(!context.bAlreadyReviewed) ?
                                        <h5>Leave a <span className="btn-link text-primary pointer" role="button"
                                                          data-toggle="modal" data-target="#reviewModal"
                                                          onClick={this.openReviewModal}>review</span></h5>
                                        :
                                        <p>You have already reviewed this spot. <span onClick={this.openReviewModal} data-target="#editReviewModal" data-toggle="modal" className="btn-link text-primary pointer" role="button">Edit</span> or <span onClick={this.openReviewModal} data-target="#deleteReviewModal" data-toggle="modal" className="btn-link text-primary pointer" role="button">Delete</span> your review.</p>
                                    }
                                    <ReviewModal action={'post'} spotname={context.state.name} path={context.state.path} />
                                    <ReviewModal action={'edit'} spotname={context.state.name} path={context.state.path} />
                                    <ReviewModal action={'delete'} spotname={context.state.name} path={context.state.path} />
                                </Fragment>
                             : <p>You must <a className="btn-link" href="https://lakescaster.com/login">login</a> or <a className="btn-link" href="https://lakescaster.com/register">register</a> to leave a review.</p>
                            }
                        </div>
                        <div className="reviews container">
                            {context.state.reviews.map((oReview, i) => {
                                return(
                                    <div className="review" key={i}>
                                        <p>{oReview.reviewer} on {oReview.reviewed_at}</p>
                                        <StarRatingComponent
                                            name={`${oReview.userId}-rating`}
                                            editing={false}
                                            starCount={5}
                                            value={oReview.rating}
                                        />
                                        <p>{oReview.review}</p>
                                    </div>
                                )
                            })}
                        </div>
                    </Fragment>
                )}
            </MyContext.Consumer>
        )
    }
}

export default Reviews;