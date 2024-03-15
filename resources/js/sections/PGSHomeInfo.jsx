import PGSInfoBox from "../components/common/PGSInfoBox"
import PGSSectionTitle from "../components/common/PGSSectionTitle"
import PGSContainer from "../components/layouts/PGSContainer"
import PGSSection from "../components/layouts/PGSSection"

const PGSHomeInfo = () => {
  return (
    <PGSSection className={'bg_grey'}>
        <PGSContainer>
            <PGSSectionTitle title={'Info Card Box'}/> 

            <div className="info_grid">
                <div className="info_bar full_">
                    <h4>Default Info</h4>
                    <PGSInfoBox 
                        title={'Default Info Title'}
                        description={"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since."}
                    />
                </div>

                <div className="info_bar full_">
                    <h4>Success Info</h4>
                    <PGSInfoBox 
                    title={'Success Info Title'}
                    description={"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since."}
                    type={'success'}/>
                </div>

                <div className="info_bar full_">
                    <h4>Warning Info</h4>
                    <PGSInfoBox 
                    title={'Warning Info Title'}
                    description={"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since."}
                    type={'warning'}/>
                </div>

                <div className="info_bar full_">
                    <h4>Danger Info</h4>
                    <PGSInfoBox 
                    title={'Danger Info Title'}
                    description={"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since."}
                    type={'danger'}/>
                </div>

            </div>
        </PGSContainer>
    </PGSSection>
  )
}

export default PGSHomeInfo