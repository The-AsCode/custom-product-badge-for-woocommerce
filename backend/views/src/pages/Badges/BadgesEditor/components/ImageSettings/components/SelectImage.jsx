// @ts-nocheck
import { __ } from '@wordpress/i18n';
import { useDispatch, useSelector } from 'react-redux';
import badgeImages from '../../../../../../../assets/badge/badgeImageData.json';
import { changeBadgeSettingProperties } from '../../../../../../features/badges/badgesSlice';
import cn from '../../../../../../utils/cn';
import SectionContainer from '../../Common/SectionContainer';
import UploadBadge from '../../Common/UploadBadge';

const SelectImage = () => {
  const dispatch = useDispatch();
  const { badge_settings } = useSelector((state) => state.badges);
  const handleBadgeSettingChange = (name, value) => {
    dispatch(changeBadgeSettingProperties({ name: name, value: value }));
  };

  const handleBadgeImageChange = (name, value) => {
    dispatch(changeBadgeSettingProperties({ name: 'type', value: 'default' }));
    dispatch(changeBadgeSettingProperties({ name: 'uploadedUrl', value: '' }));
    dispatch(changeBadgeSettingProperties({ name: name, value: value }));
  };
  return (
    <SectionContainer className='wmx-mt-6' title={__('Select Image')}>
      <div className='wmx-bg-primary/5 wmx-rounded-lg'>
        <div className='wmx-flex wmx-justify-between wmx-bg-primary/5 wmx-rounded-lg wmx-items-center'>
          <div>
            {Object.keys(badgeImages.badges).map((item) => (
              <button
                onClick={() => handleBadgeSettingChange('selectedBadgeGroup', item)}
                className={cn(
                  'wmx-capitalize wmx-rounded-lg wmx-outline-none wmx-shadow-none wmx-px-4 wmx-text-base wmx-font-semibold wmx-py-2',
                  {
                    'wmx-bg-primary/10': badge_settings.selectedBadgeGroup === item,
                  }
                )}
              >
                {item.replace(/-/g, ' ')}
              </button>
            ))}
          </div>

          <UploadBadge />
        </div>
        <div className='wmx-p-4 wmx-flex wmx-text-center wmx-flex-wrap  wmx-justify-center wmx-gap-3'>
          {badge_settings.selectedBadgeGroup &&
            badgeImages.badges[badge_settings.selectedBadgeGroup].map((badge, index) => (
              <button
                onClick={() => handleBadgeImageChange('image', badge)}
                className={cn('wmx-p-2 wmx-bg-primary/5 wmx-rounded-lg wmx-border-2 wmx-border-gray-100', {
                  'wmx-bg-primary/5 wmx-border-primary':
                    badge_settings.image.name === badge.name && badge_settings.type === 'default',
                })}
                key={index}
              >
                <img
                  className='wmx-h-16 wmx-w-auto wmx-min-w-16'
                  src={`${CPBW.badge_image_file}${badge.src}`}
                  alt='Badge Icon'
                />
              </button>
            ))}
        </div>
      </div>
    </SectionContainer>
  );
};
export default SelectImage;
