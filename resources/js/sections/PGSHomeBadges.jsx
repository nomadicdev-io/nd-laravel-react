import PGSBadge from "../components/common/PGSBadge"
import { PGSButtonGroup } from "../components/common/PGSButtons"
import PGSSectionTitle from "../components/common/PGSSectionTitle"
import PGSContainer from "../components/layouts/PGSContainer"
import PGSSection from "../components/layouts/PGSSection"

const PGSHomeBadges = () => {
  return (
    <PGSSection>
        <PGSContainer>
            <PGSSectionTitle title={'Badges Components'}/> 
            <div className="info_grid">

              <div className="info_bar full_">
                <h4>Badges - Default</h4>

                <PGSButtonGroup>
                  <PGSBadge title={'Default'}/>
                  <PGSBadge title={'Primary'} className={'primary_'}/>
                  <PGSBadge title={'Secondary'} className={'secondary_'}/>
                  <PGSBadge title={'Third'} className={'third_'}/>
                  <PGSBadge title={'Success'} className={'success_'}/>
                  <PGSBadge title={'Warning'} className={'warning_'}/>
                  <PGSBadge title={'Danger'} className={'danger_'}/>
                </PGSButtonGroup>

              </div>

              <div className="info_bar full_">
                <h4>Badges - Medium</h4>

                <PGSButtonGroup>
                  <PGSBadge title={'Default'} className={'md_'}/>
                  <PGSBadge title={'Primary'} className={'primary_ md_'}/>
                  <PGSBadge title={'Secondary'} className={'secondary_ md_'}/>
                  <PGSBadge title={'Third'} className={'third_ md_'}/>
                  <PGSBadge title={'Success'} className={'success_ md_'}/>
                  <PGSBadge title={'Warning'} className={'warning_ md_'}/>
                  <PGSBadge title={'Danger'} className={'danger_ md_'}/>
                </PGSButtonGroup>

              </div>

              <div className="info_bar full_">
                <h4>Badges - Large</h4>

                <PGSButtonGroup>
                  <PGSBadge title={'Default'} className={'lg_'}/>
                  <PGSBadge title={'Primary'} className={'primary_ lg_'}/>
                  <PGSBadge title={'Secondary'} className={'secondary_ lg_'}/>
                  <PGSBadge title={'Third'} className={'third_ lg_'}/>
                  <PGSBadge title={'Success'} className={'success_ lg_'}/>
                  <PGSBadge title={'Warning'} className={'warning_ lg_'}/>
                  <PGSBadge title={'Danger'} className={'danger_ lg_'}/>
                </PGSButtonGroup>

              </div>

              <div className="info_bar full_">
                <h4>Badges With Number</h4>

                <PGSButtonGroup>
                  <PGSBadge title={'Default'} number={'05'}/>
                  <PGSBadge title={'Primary'} className={'primary_'} number={'05'} />
                  <PGSBadge title={'Secondary'} className={'secondary_'} number={'05'}/>
                  <PGSBadge title={'Third'} className={'third_'} number={'05'}/>
                  <PGSBadge title={'Success'} className={'success_'} number={'05'}/>
                  <PGSBadge title={'Warning'} className={'warning_'} number={'05'}/>
                  <PGSBadge title={'Danger'} className={'danger_'} number={'05'}/>
                </PGSButtonGroup>

              </div>

            </div>
        </PGSContainer>
    </PGSSection>
  )
}

export default PGSHomeBadges