import {SizeProp} from '@fortawesome/fontawesome-svg-core';
import {HTMLInputTypeAttribute, ReactElement, ReactNode} from 'react';

export {};

declare global {
    type IconProps = {
        color?: string,
        size: SizeProp
    }

    type LinkProps = {
        location: string,
        label: string,
        active: boolean,
        activeAlarm: boolean
        icon?: ReactNode,
    }

    type ButtonProps = {
        label?: string,
        color?: string,
        styling?: string,
        activeColor?: string,
        onClick?: () => void,
        direction: 'row' | 'flex-row-reverse space-x-reverse'
        icon?: ReactElement;
        type: 'button' | 'submit' | 'reset' | undefined,
        form?: string,
    }

    type TabButtonProps = {
        index: number,
        title: ReactNode,
        active: boolean,
        onClick: (id: number) => void
    }

    type LineChartProps = {
        id: string;
        label: string,
        min: number,
        max: number,
        series: Series[];
        unit: string;
        strokeColor: string;
        gradientColor: string[];
    }

    type InputProps = {
        defaultValue: number | string,
        fieldName: string,
        label?: string
        value: string | number | undefined | FileList
        required: boolean,
        disabled: boolean,
        ref?: Ref<any>
    }

    type NumberInputProps = {
        max?: number,
        min?: number,
        step?: number,
        onChange?: (name: string, value: number) => void
    } & InputProps

    type StringInputProps = {
        maxLength?: number,
        minLength?: number,
        onChange?: (name: string, value: string) => void
        type?: HTMLInputTypeAttribute | undefined
    } & InputProps

    type PageTitleProps = {
        icon?: ReactElement,
        titleLabel: string,
        titleSize: string,
        children?: ReactNode;
    };
}