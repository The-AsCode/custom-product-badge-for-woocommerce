// @ts-nocheck
import { EyeDropperIcon } from '@heroicons/react/24/solid';
import { useEffect, useRef, useState } from 'react';
import ColorPicker from 'react-best-gradient-color-picker';
import Label from '../../../../../../../../components/Label';

const CustomPicker = ({ onChange = () => {}, label, hideControls = false, value = '#ffffff' }) => {
  const [isActive, setIsActive] = useState(false);
  const pickerRef = useRef(null);

  useEffect(() => {
    const handleClickOutside = (event) => {
      if (pickerRef.current && !pickerRef.current.contains(event.target)) {
        setIsActive(false);
      }
    };

    document.addEventListener('mousedown', handleClickOutside);
    return () => {
      document.removeEventListener('mousedown', handleClickOutside);
    };
  }, []);

  return (
    <div className='wmx-flex wmx-items-center wmx-gap-2'>
      <Label htmlFor='color'>{label}:</Label>
      <div className='wmx-relative' ref={pickerRef}>
        <button
          onClick={() => {
            setIsActive((prevState) => !prevState);
          }}
          style={{ background: value }}
          className='wmx-flex wmx-justify-center wmx-bg-white wmx-size-10 wmx-rounded-full wmx-items-center'
        >
          <EyeDropperIcon className='wmx-h-5 wmx-w-5' />
        </button>
        {isActive && (
          <div
            className='wmx-absolute wmx-z-40 wmx-bg-[#202020] wmx-p-1.5 wmx-shadow-lg wmx-rounded-lg'
            style={{
              top: 'calc(100% + 4px)',
              left: '50%',
              transform: 'translateX(-50%)',
            }}
          >
            <ColorPicker
              height={150}
              width={270}
              hideControls={hideControls}
              className='wmx-rounded-lg'
              hidePresets
              hideAdvancedSliders
              hideColorGuide
              onChange={(value) => onChange(value)}
              value={value}
            />
          </div>
        )}
      </div>
    </div>
  );
};

export default CustomPicker;
