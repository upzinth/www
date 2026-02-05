import React from "react";
import { GestureResponderEvent, StyleProp, ViewStyle } from "react-native";
import { TouchableHighlight as RCTouchableHighlight } from "react-native-gesture-handler";

import { Theme } from "../../theme";

type TProps = {
  underlayColor?: string;
  onPress?: () => void;
  style?: StyleProp<ViewStyle>;
  children: React.ReactNode
};

export const TouchableHighlight: React.FC<TProps> = (props) => (
  <RCTouchableHighlight
    underlayColor={
      props.underlayColor || Theme.colors.touchableHighlightUnderlayColor
    }
    onPress={props.onPress}
    style={props.style}
  >
    {props.children}
  </RCTouchableHighlight>
);
