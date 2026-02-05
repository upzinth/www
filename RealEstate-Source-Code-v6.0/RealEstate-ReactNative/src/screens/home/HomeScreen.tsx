import { useNavigation } from "@react-navigation/native";
import React, { Fragment, useEffect, useState } from "react";
import {
  Animated,
  Dimensions,
  ScrollView,
  StyleSheet,
  View,
  RefreshControl,
  I18nManager,
} from "react-native";
import SafeAreaView from "react-native-safe-area-view";
import Carousel from "react-native-snap-carousel";

import {
  HomeHeaderView,
  HomeHighlightedItemView,
  HomeTopSearchItemView,
  ListingItemView,
  SectionHeader,
  Separator,
} from "../../components";
import { useLocalization } from "../../localization";
import { Property, DashboardModel } from "../../models";
import NavigationNames from "../../navigations/NavigationNames";
import { DashboardService } from "../../services";
import { Theme } from "../../theme";

const HEADER_HEIGHT = 230;
const WINDOW_WIDTH = Dimensions.get("window").width;

export const HomeScreen = () => {
  const { getString } = useLocalization();
  const navigation = useNavigation();
  const offset = new Animated.Value(0);
  const [dashboardModel, setDashboardModel] = useState<DashboardModel>(null);

  const onClickListingItem = (item: Property) => {
    navigation.navigate(NavigationNames.PropertyDetailScreenForHomeTab, {
      model: { ...item },
    } as never);
  };

  const fetchDashboardItems = () => {
    DashboardService.getDashboardItems()
      .then((res) => {
        setDashboardModel(res.data);
      })
      .catch((err) => console.log(err));
  };

  useEffect(() => fetchDashboardItems(), []);

  if (dashboardModel == null) {
    return null;
  }

  return (
    <View style={styles.container}>
      <HomeHeaderView
        animValue={offset}
        height={HEADER_HEIGHT}
        headerImages={dashboardModel.headerImages}
        onPressSearchInput={() =>
          navigation.navigate(NavigationNames.SearchTab, {
            screen: NavigationNames.SearchScreen,
            params: { focusSearchInput: "1" },
          } as never)
        }
      />
      <SafeAreaView
        style={styles.contentContainer}
        forceInset={{ top: "always" }}
      >
        <ScrollView
          style={styles.scrollViewContainer}
          contentContainerStyle={styles.scrollViewContentContainerStyle}
          scrollEventThrottle={16}
          showsVerticalScrollIndicator={false}
          refreshControl={
            <RefreshControl
              refreshing={false}
              onRefresh={() => fetchDashboardItems()}
            />
          }
          onScroll={Animated.event([
            { nativeEvent: { contentOffset: { y: offset } } },
          ], { useNativeDriver: false })}
        >
          <SectionHeader title={getString("Highlight")} />
          <Carousel
            layout={I18nManager.isRTL ? "default" : "stack" as const}
            data={dashboardModel.featuredProperties}
            renderItem={({ item }) => (
              <HomeHighlightedItemView
                item={item}
                onClick={() => onClickListingItem(item)}
              />
            )}
            sliderWidth={WINDOW_WIDTH}
            itemWidth={WINDOW_WIDTH - 32}
            vertical={false}
          />

          <SectionHeader title={getString("Top Searches")} mTop={16} />

          <ScrollView
            horizontal={true}
            showsHorizontalScrollIndicator={false}
            contentContainerStyle={{ paddingStart: 16 }}>
            {
              dashboardModel.topSearchCities.map(item => {
                return <Fragment key={item.id}>
                  <HomeTopSearchItemView
                    item={item}
                    onClick={() =>
                      navigation.navigate(NavigationNames.SearchTab, {
                        screen: NavigationNames.SearchScreen,
                        params: { searchCity: item },
                      } as never)
                    }
                  />
                  <Separator horizontal />
                </Fragment>
              })
            }
          </ScrollView>

          <SectionHeader title={getString("Today New")} mTop={16} />
          <Separator height={8} />
          {
            dashboardModel.newProperties.map(item => <Fragment key={item.id}>
              <ListingItemView
                model={item}
                onClick={() => onClickListingItem(item)}
              />
              <Separator height={16} />
            </Fragment>
            )
          }

        </ScrollView>
      </SafeAreaView>
    </View>
  );
};

const styles = StyleSheet.create({
  container: { flex: 1 },
  flex1: { flex: 1 },
  contentContainer: { flex: 1 },
  scrollViewContainer: {
    flex: 1,
    backgroundColor: Theme.colors.windowBackground,
  },
  scrollViewContentContainerStyle: { paddingTop: HEADER_HEIGHT + 16 },
});
