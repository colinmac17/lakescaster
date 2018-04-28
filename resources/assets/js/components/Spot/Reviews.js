import React, {Component, Fragment} from 'react';
import {MyContext} from '../Provider';
import { ReviewModal } from '../Nuggets/ReviewModal';

class Reviews extends Component{
    constructor(props) {
        super(props)
        this.state = {
            data: {}
        }

        this.openReviewModal = this.openReviewModal.bind(this)
    }

    openReviewModal(e){
        e.preventDefault()
    }

    render(){
        return(
            <MyContext.Consumer>
                {(context) => (
                    <Fragment>
                        <h1>Reviews for {context.state.name}</h1>
                        <div className="reviews">
                            {(context.state.bUser == 1)
                                ? <Fragment>
                                    <h5>Leave a <span className="btn-link text-primary pointer" role="button" data-toggle="modal" data-target="#reviewModal" onClick={this.openReviewModal}>review</span></h5>
                                    <ReviewModal spotname={context.state.name} path={context.state.path} />
                                </Fragment>
                             : <p>You must <a className="btn-link" href="https://lakescaster.com/register">register</a> to leave a review.</p>
                            }
                        </div>
                    </Fragment>
                )}
            </MyContext.Consumer>
        )
    }
}

export default Reviews;