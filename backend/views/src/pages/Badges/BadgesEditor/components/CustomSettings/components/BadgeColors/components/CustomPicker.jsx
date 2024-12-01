// @ts-nocheck
import { EyeDropperIcon } from '@heroicons/react/24/solid';
import { useEffect, useRef, useState } from 'react';
import ColorPicker from 'react-best-gradient-color-picker';
import Label from '../../../../../../../../components/Label';

const blendWithBackground = ({ r, g, b, a }, bg = { r: 228, g: 234, b: 241 }) => {
  const blendedR = Math.round(a * r + (1 - a) * bg.r);
  const blendedG = Math.round(a * g + (1 - a) * bg.g);
  const blendedB = Math.round(a * b + (1 - a) * bg.b);
  return { r: blendedR, g: blendedG, b: blendedB };
};

const parseColor = (color) => {
  if (color.startsWith('#')) {
    const hex = color.replace('#', '');
    const r = parseInt(hex.substring(0, 2), 16);
    const g = parseInt(hex.substring(2, 4), 16);
    const b = parseInt(hex.substring(4, 6), 16);
    return { r, g, b, a: 1 };
  }

  const rgbRegex = /rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)/;
  const match = color.match(rgbRegex);
  if (match) {
    const [, r, g, b, a = 1] = match.map(Number);
    return { r, g, b, a: parseFloat(a) };
  }

  return { r: 255, g: 255, b: 255, a: 1 };
};

const getContrastColor = (backgroundColor) => {
  const parsedColor = parseColor(backgroundColor);
  const { r, g, b } = parsedColor.a < 1 ? blendWithBackground(parsedColor) : parsedColor;
  const brightness = (r * 299 + g * 587 + b * 114) / 1000;
  return brightness > 128 ? '#000000' : '#FFFFFF';
};

const CustomPicker = ({ onChange = () => {}, label, hideControls = false, value = '#ffffff' }) => {
  const [isActive, setIsActive] = useState(false);
  const pickerRef = useRef(null);
  const [textColor, setTextColor] = useState('#000000');

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

  useEffect(() => {
    if (value.startsWith('#') || value.startsWith('rgba') || value.startsWith('rgb')) {
      setTextColor(getContrastColor(value));
    }
  }, [value]);

  return (
    <div className='wmx-flex wmx-items-center wmx-gap-2'>
      <Label htmlFor='color'>{label}:</Label>
      <div className='wmx-relative' ref={pickerRef}>
        <button
          onClick={() => {
            setIsActive((prevState) => !prevState);
          }}
          style={{ background: value, color: textColor }}
          className='wmx-flex wmx-justify-center wmx-border wmx-border-gray-300 wmx-size-10 wmx-rounded-full wmx-items-center'
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
