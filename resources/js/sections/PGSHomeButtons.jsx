import { PGSButton, PGSButtonGroup, PGSIconButton } from "../components/common/PGSButtons"
import PGSSectionTitle from "../components/common/PGSSectionTitle"
import PGSContainer from "../components/layouts/PGSContainer"
import PGSSection from "../components/layouts/PGSSection"
import { 
    FaArrowRight,
    FaArrowLeft,
    FaArrowDown,
    FaPhone, 
    FaEnvelope, 
    FaLock,  
    FaArrowUp,
    FaCircleCheck,
    FaCircleXmark,
    FaCircleExclamation
} from "react-icons/fa6";
import {useState} from 'react'

const PGSHomeButtons = () => {

    const [isLoading, setIsLoading] = useState(false)

  return (
    <PGSSection className={'bg_grey'}>
        <PGSContainer>
            <PGSSectionTitle title={'Buttons & Button Groups Components'}/> 

            <div className="info_grid">
                <div className="info_bar full_">
                    <h4>Nomral Buttons</h4>
                    <PGSButtonGroup>
                        <PGSButton 
                            title={'Default Button'}
                            type={'button'}
                        />

                        <PGSButton 
                            title={'Primary Button'}
                            type={'button'}
                            className={'primary_'}
                            onClick={()=> console.log('Clicked')}
                        />

                        <PGSButton 
                            title={'Secondary Button'}
                            type={'button'}
                            className={'secondary_'}
                            onClick={()=> console.log('Clicked')}
                        />

                        <PGSButton 
                            title={'Third Button'}
                            type={'button'}
                            className={'third_'}
                            onClick={()=> console.log('Clicked')}
                        />

                        <PGSButton 
                            title={'Success Button'}
                            type={'button'}
                            className={'success_'}
                            onClick={()=> console.log('Clicked')}
                        />

                        <PGSButton 
                            title={'Warning Button'}
                            type={'button'}
                            className={'warning_'}
                            onClick={()=> console.log('Clicked')}
                        />

                        <PGSButton 
                            title={'Danger Button'}
                            type={'button'}
                            className={'danger_'}
                            onClick={()=> console.log('Clicked')}
                        />
                    </PGSButtonGroup>
                </div>

                <div className="info_bar full_">
                    <h4>Buttons With Icons</h4>

                    <PGSButtonGroup>
                    <PGSButton 
                            title={'Default Button'}
                            type={'button'}
                            icon={<FaArrowRight />}
                        />

                        <PGSButton 
                            title={'Primary Button'}
                            type={'button'}
                            className={'primary_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaPhone />}
                        />

                        <PGSButton 
                            title={'Secondary Button'}
                            type={'button'}
                            className={'secondary_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaEnvelope />}
                        />

                        <PGSButton 
                            title={'Third Button'}
                            type={'button'}
                            className={'third_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaLock />}
                        />

                        <PGSButton 
                            title={'Success Button'}
                            type={'button'}
                            className={'success_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaCircleCheck />}
                        />

                        <PGSButton 
                            title={'Warning Button'}
                            type={'button'}
                            className={'warning_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaCircleExclamation />}
                        />

                        <PGSButton 
                            title={'Danger Button'}
                            type={'button'}
                            className={'danger_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaCircleXmark />}
                        />
                    </PGSButtonGroup>
                </div>

                <div className="info_bar full_">
                    <h4>Button with Loader</h4>

                    <PGSButtonGroup>
                        <PGSButton 
                            title={'Click Me'}
                            type={'button'}
                            loader={isLoading}
                            onClick={()=> setIsLoading(!isLoading)}
                            icon={<FaArrowRight />}
                        />
                    </PGSButtonGroup>
                </div>

                <div className="info_bar full_">
                    <h4>Outline Buttons</h4>

                    <PGSButtonGroup>
                        <PGSButton 
                            title={'Default Button'}
                            type={'button'}
                            className={'outline_'}
                            onClick={()=> console.log('Clicked')}
                        />

                        <PGSButton 
                            title={'Primary Button'}
                            type={'button'}
                            className={'primary_ outline_'}
                            onClick={()=> console.log('Clicked')}
                        />

                        <PGSButton 
                            title={'Secondary Button'}
                            type={'button'}
                            className={'secondary_ outline_'}
                            onClick={()=> console.log('Clicked')}
                        />

                        <PGSButton 
                            title={'Third Button'}
                            type={'button'}
                            className={'third_ outline_'}
                            onClick={()=> console.log('Clicked')}
                        />

                        <PGSButton 
                            title={'Success Button'}
                            type={'button'}
                            className={'success_ outline_'}
                            onClick={()=> console.log('Clicked')}
                        />

                        <PGSButton 
                            title={'Warning Button'}
                            type={'button'}
                            className={'warning_ outline_'}
                            onClick={()=> console.log('Clicked')}
                        />

                        <PGSButton 
                            title={'Danger Button'}
                            type={'button'}
                            className={'danger_ outline_'}
                            onClick={()=> console.log('Clicked')}
                        />
                    </PGSButtonGroup>

                </div>

                <div className="info_bar full_">
                    <h4>Outline Buttons With Icons</h4>

                    <PGSButtonGroup>
                    <PGSButton 
                            title={'Default Button'}
                            type={'button'}
                            className={'outline_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaArrowRight />}
                        />

                        <PGSButton 
                            title={'Primary Button'}
                            type={'button'}
                            className={'primary_ outline_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaPhone />}
                        />

                        <PGSButton 
                            title={'Secondary Button'}
                            type={'button'}
                            className={'secondary_ outline_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaEnvelope />}
                        />

                        <PGSButton 
                            title={'Third Button'}
                            type={'button'}
                            className={'third_ outline_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaLock />}
                        />

                        <PGSButton 
                            title={'Success Button'}
                            type={'button'}
                            className={'success_ outline_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaCircleCheck />}
                        />

                        <PGSButton 
                            title={'Warning Button'}
                            type={'button'}
                            className={'warning_ outline_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaCircleExclamation />}
                        />

                        <PGSButton 
                            title={'Danger Button'}
                            type={'button'}
                            className={'danger_ outline_'}
                            onClick={()=> console.log('Clicked')}
                            icon={<FaCircleXmark />}
                        />
                    </PGSButtonGroup>
                </div>

                <div className="info_bar full_">
                    <h4>Icon Buttons</h4>

                    <PGSButtonGroup>
                        <PGSIconButton icon={<FaArrowLeft />} onClick={()=> console.log('Clicked')} type={'button'}/>
                        <PGSIconButton icon={<FaArrowRight />} onClick={()=> console.log('Clicked')} type={'button'} className={'primary_'}/>
                        <PGSIconButton icon={<FaArrowUp />} onClick={()=> console.log('Clicked')} type={'button'} className={'secondary_'}/>
                        <PGSIconButton icon={<FaArrowDown />} onClick={()=> console.log('Clicked')} type={'button'} className={'third_'}/>
                        <PGSIconButton icon={<FaCircleCheck />} onClick={()=> console.log('Clicked')} type={'button'} className={'success_'}/>
                        <PGSIconButton icon={<FaCircleExclamation />} onClick={()=> console.log('Clicked')} type={'button'} className={'warning_'}/>
                        <PGSIconButton icon={<FaCircleXmark />} onClick={()=> console.log('Clicked')} type={'button'} className={'danger_'}/>
                    </PGSButtonGroup>
                </div>

                <div className="info_bar full_">
                    <h4>Outline Icon Buttons</h4>

                    <PGSButtonGroup>
                        <PGSIconButton icon={<FaArrowLeft />} onClick={()=> console.log('Clicked')} type={'button'} className={'outline_'}/>
                        <PGSIconButton icon={<FaArrowRight />} onClick={()=> console.log('Clicked')} type={'button'} className={'primary_ outline_'}/>
                        <PGSIconButton icon={<FaArrowUp />} onClick={()=> console.log('Clicked')} type={'button'} className={'secondary_ outline_'}/>
                        <PGSIconButton icon={<FaArrowDown />} onClick={()=> console.log('Clicked')} type={'button'} className={'third_ outline_'}/>
                        <PGSIconButton icon={<FaCircleCheck />} onClick={()=> console.log('Clicked')} type={'button'} className={'success_ outline_'}/>
                        <PGSIconButton icon={<FaCircleExclamation />} onClick={()=> console.log('Clicked')} type={'button'} className={'warning_ outline_'}/>
                        <PGSIconButton icon={<FaCircleXmark />} onClick={()=> console.log('Clicked')} type={'button'} className={'danger_ outline_'}/>
                    </PGSButtonGroup>
                </div>
            </div>

        </PGSContainer>
    </PGSSection>
  )
}

export default PGSHomeButtons