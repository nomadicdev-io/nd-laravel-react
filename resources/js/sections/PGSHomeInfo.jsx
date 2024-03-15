import PGSSectionTitle from "../components/common/PGSSectionTitle"
import PGSContainer from "../components/layouts/PGSContainer"
import PGSSection from "../components/layouts/PGSSection"

const PGSHomeInfo = () => {
  return (
    <PGSSection className={'bg_grey'}>
        <PGSContainer>
            <PGSSectionTitle title={'Info Card Box'}/> 
        </PGSContainer>
    </PGSSection>
  )
}

export default PGSHomeInfo